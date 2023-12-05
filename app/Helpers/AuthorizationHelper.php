<?php

namespace App\Helpers;

use App\Models\Authorization;
use App\Models\AuthorizationType;
use App\Models\UserAuthorizationType;
use App\Models\User;
use App\Models\UserCash;
use App\Models\UserCashHistory;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AuthorizationHelper
{

    public static function users($type, $id_user = null)
    {
        $authorization_type = AuthorizationType::where('type', $type)->select('id_authorization_type')->pluck('id_authorization_type')->toArray();
        if (count($authorization_type) > 0) {
            $id_authorization_type = $authorization_type[0];
            if ($id_user == null) {
                $id_user = Auth::id();
            }

            $users_authorizations_types = UserAuthorizationType::where([
                'id_authorization_type' => $id_authorization_type,
                'id_user_child' => $id_user
            ])->distinct()->pluck('id_user_parent')->toArray();

            if (count($users_authorizations_types) > 0) {
                $users = User::whereIn('id_user', $users_authorizations_types)->get();
                return $users->toArray();
            } else {
                return [];
            }
        } else {
            return [];
        }
    }

    public static function pending($id_user = null)
    {
        if ($id_user == null) {
            $id_user = Auth::id();
        }

        $authorization = Authorization::with(['clients', 'statuses', 'user', 'authorization_type'])
            ->whereHas('statuses', function ($query) use ($id_user) {
                $query->where('authorizations_statuses.id_user', $id_user)->whereNull('approved');
            })
            ->where(['active' => 1, 'approved' => null])
            ->latest()->get();

        return $authorization;
    }

    public static function active($type, $id_user = null)
    {
        if ($id_user == null) {
            $id_user = Auth::id();
        }

        $authorization = Authorization::with(['clients', 'statuses', 'user', 'authorization_type'])
            ->whereHas('authorization_type', function ($query) use ($type) {
                $query->where('authorizations_types.type', $type);
            })
            ->where(['id_user' => $id_user, 'active' => 1, 'approved' => 1])
            ->latest()->get();

        return $authorization;
    }

    public static function pendingAuthorization($id_authorization, $id_user = null)
    {
        if ($id_user == null) {
            $id_user = Auth::id();
        }

        $count = Authorization::with(['clients', 'statuses', 'user', 'authorization_type'])
            ->whereHas('statuses', function ($query) use ($id_user) {
                $query->where('authorizations_statuses.id_user', $id_user)->whereNull('approved');
            })
            ->where(['active' => 1, 'approved' => null])
            ->where(['id_authorization' => $id_authorization])
            ->count();

        return $count > 0;
    }

    public static function refresh($id)
    {
        $authorization = Authorization::with(['authorization_statuses', 'authorization_type'])->find($id);
        $approval = $authorization->authorization_type->approval;

        $approved = null;

        $st_yes = 0;
        $st_no = 0;
        $st_pending = 0;
        foreach ($authorization->authorization_statuses as $status) {
            if ($status->approved === 1) {
                $st_yes++;
            } elseif ($status->approved === 0) {
                $st_no++;
            } else {
                $st_pending++;
            }
        }

        if ($approval == "all") {
            if ($st_no <= 0 && $st_pending <= 0 && $st_yes > 0) {
                $approved = 1;
            } elseif ($st_no > 0) {
                $approved = 0;
            }
        } else {
            if ($st_no > 0) {
                $approved = 0;
            } elseif ($st_yes > 0) {
                $approved = 1;
            }
        }

        $end_datetime = Carbon::parse($authorization->end_datetime);
        $today = Carbon::now();
        $diff = $today->diffInDays($end_datetime);

        $active = 1;
        if ($diff > 32) {
            $active = 0;
        } elseif ($authorization->authorization_type->type == 'cash-advance' && $approved !== null) {
            $active = 0;
        }

        $authorization->update(compact('approved', 'active'));

        //Atualiza os valores de adiantamento do usuário
        if ($authorization->authorization_type->type == 'cash-advance' && $approved == true) {
            $user_cash_history = UserCashHistory::where('id_authorization', $id)->first();
            if (!$user_cash_history) {
                $previous_balance = UserCashHistory::where('id_user', $authorization->id_user)->sum('amount');
                $current_balance = $authorization->amount + $previous_balance;

                Transaction::where(['id_authorization' => $id, 'type' => $authorization->authorization_type->type])->delete();
                $transaction = Transaction::create([
                    'type' => $authorization->authorization_type->type,
                    'id_authorization' => $id,
                    'id_user' => $authorization->id_user,
                    'amount' => $authorization->amount,
                    'description' => 'Pagamento de Adiantamento',
                ]);

                UserCashHistory::create([
                    'id_transaction' => $transaction->id_transaction,
                    'id_authorization' => $id,
                    'id_user' => $authorization->id_user,
                    'amount' => $authorization->amount,
                    'previous_balance' => $previous_balance,
                    'current_balance' => $current_balance,
                ]);

                UserCash::where('id_user', $authorization->id_user)->delete();
                if ($current_balance > 0) {
                    UserCash::create([
                        'id_user' => $authorization->id_user,
                        'amount' => $current_balance,
                    ]);
                }
            }
        }
    }
}
