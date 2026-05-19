 <div class="card stat h-100">
     <div class="card-body">
         @if (!empty($title) || !empty($icon))
             <div class="card-title">
                 @if (!empty($icon))
                     <span class="card-icon">
                         <i class="{{ $icon }}"></i>
                     </span>
                 @endif
                 {{ $title }}
             </div>
         @endif
         <p class="stat-value">{{ $slot }}</p>
         <div class="card-subtitle">
             <span class="stat-delta">
                 @if (!empty($infoIcon))
                     <i class="{{ $infoIcon }}"></i>
                 @endif
                 @if (!empty($infoValue))
                     {{ $infoValue }}
                 @endif
             </span>
             {{ $info }}
         </div>
     </div>
 </div>
