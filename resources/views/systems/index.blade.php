@extends('layouts.app')
@section('title', request('__route')['label'])
@section('breadcrumb', json_encode([request('__route')]))

@section('content')

    <div class="row">

        <div class="col-md-12">

            <div class="panel">

                <div class="panel-body">
                    <form role="form">
                        <div class="form-group">
                            <label class="col-lg-3 control-label">Static Field</label>
                            <div class="col-lg-8">
                                <p class="form-control-static text-muted">email@example.com</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputStandard" class="col-lg-3 control-label">Standard</label>
                            <div class="col-lg-8">
                                <input type="text" id="inputStandard" class="form-control" placeholder="Type Here...">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword" class="col-lg-3 control-label">Password</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" id="inputPassword" placeholder="Password">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="disabledInput" class="col-lg-3 control-label">Disabled</label>
                            <div class="col-lg-8">
                                <input class="form-control" id="disabledInput" type="text" placeholder="A Disabled Form"
                                    disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="textArea1">Text Area Expand</label>
                            <div class="col-lg-8">
                                <textarea class="form-control textarea-grow" id="textArea1" rows="4"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="textArea2">Text Area</label>
                            <div class="col-lg-8">
                                <textarea class="form-control" id="textArea2" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-3 control-label" for="textArea3">Disabled Text Area</label>
                            <div class="col-lg-8">
                                <textarea class="form-control" id="textArea3" rows="3" disabled></textarea>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="panel">
                <div class="panel-heading">
                    <span class="panel-title">Standard Fields</span>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form">
                        <div class="form-group has-primary">
                            <label class="col-lg-3 control-label" for="inputPrimary">Primary Field</label>
                            <div class="col-lg-8">
                                <span class="append-icon right"><i class="fa fa-gear"></i>
                                </span>
                                <input type="text" class="form-control" id="inputPrimary">
                            </div>
                        </div>
                        <div class="form-group has-success">
                            <label class="col-lg-3 control-label" for="inputSuccess">Success Field</label>
                            <div class="col-lg-8">
                                <span class="append-icon right"><i class="fa fa-check"></i>
                                </span>
                                <input type="text" class="form-control" id="inputSuccess">
                            </div>
                        </div>
                        <div class="form-group has-info">
                            <label class="col-lg-3 control-label" for="inputInfo">Info Field</label>
                            <div class="col-lg-8">
                                <span class="append-icon right"><i class="fa fa-exclamation-circle"></i>
                                </span>
                                <input type="text" class="form-control" id="inputInfo">
                            </div>
                        </div>
                        <div class="form-group has-warning">
                            <label class="col-lg-3 control-label" for="inputWarning">Warning Field</label>
                            <div class="col-lg-8">
                                <span class="append-icon right"><i class="fa fa-exclamation-triangle"></i>
                                </span>
                                <input type="text" class="form-control" id="inputWarning">
                            </div>
                        </div>
                        <div class="form-group has-error">
                            <label class="col-lg-3 control-label" for="inputError">Error Field</label>
                            <div class="col-lg-8">
                                <span class="append-icon right"><i class="fa fa-remove"></i>
                                </span>
                                <input type="text" class="form-control" id="inputError">
                            </div>
                        </div>
                        <div class="form-group has-alert">
                            <label class="col-lg-3 control-label" for="inputAlert">Alert Field</label>
                            <div class="col-lg-8">
                                <span class="append-icon right"><i class="fa fa-flag"></i>
                                </span>
                                <input type="text" class="form-control" id="inputAlert">
                            </div>
                        </div>
                        <div class="form-group has-system">
                            <label class="col-lg-3 control-label" for="inputSystem">System Field</label>
                            <div class="col-lg-8">
                                <span class="append-icon right"><i class="fa fa-bell"></i>
                                </span>
                                <input type="text" class="form-control" id="inputSystem">
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="panel">
                <div class="panel-heading">
                    <span class="panel-title">Easy Icons</span>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form">
                        <label class="col-md-2 text-right">With Icons</label>
                        <div class="col-md-10 ph30">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-envelope-o"></i>
                                    </span>
                                    <input class="form-control" type="text" placeholder="Email address">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-key"></i>
                                    </span>
                                    <input class="form-control" type="password" placeholder="Password">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <input class="form-control" type="text" placeholder="Numbers">
                                    <span class="input-group-addon">00</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <input class="form-control" type="password" placeholder="Money">
                                    <span class="input-group-addon"><i class="fa fa-usd"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>

            <div class="panel">
                <div class="panel-heading">
                    <span class="panel-title">Fields Options</span>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form">
                        <div class="form-group">
                            <label class="col-lg-2 control-label" for="inputSmall">Small</label>
                            <div class="col-lg-10">
                                <input id="inputSmall" class="form-control input-sm" type="text"
                                    placeholder=".input-sm">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label" for="inputDefault">Default</label>
                            <div class="col-lg-10">
                                <input id="inputDefault" class="form-control" type="text"
                                    placeholder="default style">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label" for="inputLarge">Large</label>
                            <div class="col-lg-10">
                                <input id="inputLarge" class="form-control input-lg" type="text"
                                    placeholder=".input-lg">
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-md-2 text-right">Input Lengths</label>
                            <div class="col-xs-2">
                                <input type="text" class="form-control" placeholder=".col-xs-2">
                            </div>
                            <div class="col-xs-3">
                                <input type="text" class="form-control" placeholder=".col-xs-3">
                            </div>
                            <div class="col-xs-5">
                                <input type="text" class="form-control" placeholder=".col-xs-4">
                            </div>
                        </div>
                        <hr />
                        <div class="form-group">
                            <label for="inputInline" class="col-lg-2 control-label">Inline Help Text</label>
                            <div class="col-lg-5">
                                <input id="inputInline" type="text" class="form-control" placeholder="Text Field">
                            </div>
                            <div class="col-lg-4 pl5">
                                <span class="help-block mt5"><i class="fa fa-bell"></i> A block of help text!</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputHelp" class="col-lg-2 control-label">Help Text</label>
                            <div class="col-lg-10">
                                <input id="inputHelp" type="text" class="form-control" placeholder="Text Field">
                                <span class="help-block mt5"><i class="fa fa-bell"></i> A block of help text that can
                                    help the user</span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="panel">
                <div class="panel-heading">
                    <span class="panel-title">Masked Input Fields</span>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form">
                        <div class="form-group">
                            <label for="maskedDate" class="col-lg-2 control-label">Date</label>
                            <div class="col-lg-10">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i>
                                    </span>
                                    <input type="text" id="maskedDate" class="form-control date" maxlength="10"
                                        autocomplete="off" placeholder="11/11/1111">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="maskedTime" class="col-lg-2 control-label">Time</label>
                            <div class="col-lg-10">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-clock-o"></i>
                                    </span>
                                    <input type="text" id="maskedTime" class="form-control time" maxlength="10"
                                        autocomplete="off" placeholder="00:00:00">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="maskedMultiple" class="col-lg-2 control-label">Date and Time</label>
                            <div class="col-lg-10">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-clock-o"></i>
                                    </span>
                                    <input type="text" id="maskedMultiple" class="form-control date_time"
                                        maxlength="10" autocomplete="off" placeholder="99/99/9999 00:00:00">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="maskedZip" class="col-lg-2 control-label">Zip Code</label>
                            <div class="col-lg-10">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-bolt"></i>
                                    </span>
                                    <input type="text" id="maskedZip" class="form-control zip" maxlength="10"
                                        autocomplete="off" placeholder="99999-999">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="maskedPhone" class="col-lg-2 control-label">Phone</label>
                            <div class="col-lg-10">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-phone"></i>
                                    </span>
                                    <input type="text" id="maskedPhone" class="form-control phone" maxlength="10"
                                        autocomplete="off" placeholder="(999) 999-9999">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="maskedExt" class="col-lg-2 control-label">Phone + Ext</label>
                            <div class="col-lg-10">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-phone"></i>
                                    </span>
                                    <input type="text" id="maskedExt" class="form-control phoneext" maxlength="10"
                                        autocomplete="off" placeholder="9999-9999">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="maskedMoney" class="col-lg-2 control-label">Money</label>
                            <div class="col-lg-10">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-usd"></i>
                                    </span>
                                    <input type="text" id="maskedMoney" class="form-control money" maxlength="10"
                                        autocomplete="off" placeholder="000.000.000.000">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="maskedKey" class="col-lg-2 control-label">Product Key</label>
                            <div class="col-lg-10">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-key"></i>
                                    </span>
                                    <input type="text" id="maskedKey" class="form-control product" maxlength="10"
                                        autocomplete="off" placeholder="000.000.000.000,00">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="maskedID" class="col-lg-2 control-label">Tax ID</label>
                            <div class="col-lg-10">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-gavel"></i>
                                    </span>
                                    <input type="text" id="maskedID" class="form-control tin" maxlength="10"
                                        autocomplete="off" placeholder="99999-999">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="maskedSSN" class="col-lg-2 control-label">SSN</label>
                            <div class="col-lg-10">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-exclamation"></i>
                                    </span>
                                    <input type="text" id="maskedSSN" class="form-control ssn" maxlength="10"
                                        autocomplete="off" placeholder="999-99-9999">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="maskedScript" class="col-lg-2 control-label">Eye Script</label>
                            <div class="col-lg-10">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-eye"></i>
                                    </span>
                                    <input type="text" id="maskedScript" class="form-control eyescript"
                                        maxlength="10" autocomplete="off" placeholder="0ZZ.0ZZ.0ZZ.0ZZ">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="maskedCustom" class="col-lg-2 control-label">Custom</label>
                            <div class="col-lg-10">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-flask"></i>
                                    </span>
                                    <input type="text" id="maskedCustom" class="form-control custom" maxlength="10"
                                        autocomplete="off" placeholder="1-22-333-4444">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- SPINNERS -->
            <div class="panel">
                <div class="panel-heading">
                    <span class="panel-title">Speciality Spinners</span>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form">
                        <div class="form-group">
                            <label for="spinner1" class="col-lg-2 control-label">Default</label>
                            <div class="col-lg-6">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-level-up"></i>
                                    </span>
                                    <input id="spinner1" class="form-control ui-spinner-input" name="spinner"
                                        value="15" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="spinner2" class="col-lg-2 control-label">Currenc</label>
                            <div class="col-lg-6">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-usd"></i>
                                    </span>
                                    <input id="spinner2" class="form-control ui-spinner-input" name="spinner"
                                        value="35" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="spinner3" class="col-lg-2 control-label">Decimal</label>
                            <div class="col-lg-6">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-signal"></i>
                                    </span>
                                    <input id="spinner3" class="form-control ui-spinner-input" name="spinner"
                                        value="13.5" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="spinner4" class="col-lg-2 control-label">Time</label>
                            <div class="col-lg-6">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-clock-o"></i>
                                    </span>
                                    <input id="spinner4" class="form-control ui-spinner-input" name="spinner"
                                        value="08:30 PM" />
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- SELECT LISTS -->
            <div class="panel">
                <div class="panel-heading">
                    <span class="panel-title">Select Lists</span>
                </div>
                <div class="panel-body">

                    <div class="row">
                        <div class="col-sm-7">
                            <form class="form-horizontal" role="form">
                                <div class="form-group">
                                    <label for="multiselect1" class="col-md-4 control-label">Single</label>
                                    <div class="col-md-8">
                                        <select id="multiselect1" data-mdb-clear-button="true">
                                            <option value="cheese">Cheese</option>
                                            <option value="tomatoes">Tomatoes</option>
                                            <option value="mozarella">Mozzarella</option>
                                            <option value="mushrooms">Mushrooms</option>
                                            <option value="pepperoni">Pepperoni</option>
                                            <option value="onions">Onions</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="multiselect2" class="col-md-4 control-label">Multiple</label>
                                    <div class="col-md-8">
                                        <select id="multiselect2" multiple="multiple">
                                            <option value="cheese">Cheese</option>
                                            <option value="tomatoes">Tomatoes</option>
                                            <option value="mozarella">Mozzarella</option>
                                            <option value="mushrooms">Mushrooms</option>
                                            <option value="pepperoni">Pepperoni</option>
                                            <option value="onions">Onions</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="multiselect3" class="col-md-4 control-label">With Labels</label>
                                    <div class="col-md-8">
                                        <select id="multiselect3" class="multiselect-withlabels" multiple="multiple">
                                            <optgroup label="Mathematics">
                                                <option value="analysis">Analysis</option>
                                                <option value="discrete">Discrete Mathematics</option>
                                                <option value="probability">Probability Theory</option>
                                            </optgroup>
                                            <optgroup label="Computer Science">
                                                <option value="programming">Introduction to Programming</option>
                                                <option value="automata">Automata Theory</option>
                                                <option value="complexity">Complexity Theory</option>
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="multiselect4" class="col-md-4 control-label">With Sorting</label>
                                    <div class="col-md-8">
                                        <select id="multiselect4" multiple="multiple">
                                            <option value="cheese">Cheese</option>
                                            <option value="tomatoes">Tomatoes</option>
                                            <option value="mozarella">Mozzarella</option>
                                            <option value="mushrooms">Mushrooms</option>
                                            <option value="pepperoni">Pepperoni</option>
                                            <option value="onions">Onions</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-sm-5">
                            <form class="form-horizontal" role="form">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <select id="multiselect5">
                                            <option value="cheese">Cheese</option>
                                            <option value="tomatoes">Tomatoes</option>
                                            <option value="mozarella" selected>Mozzarella</option>
                                            <option value="mushrooms">Mushrooms</option>
                                            <option value="pepperoni">Pepperoni</option>
                                            <option value="onions">Onions</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <select id="multiselect6" multiple="multiple">
                                            <option value="cheese">Cheese</option>
                                            <option value="tomatoes">Tomatoes</option>
                                            <option value="mozarella">Mozzarella</option>
                                            <option value="mushrooms">Mushrooms</option>
                                            <option value="pepperoni">Pepperoni</option>
                                            <option value="onions">Onions</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <select id="multiselect7" class="multiselect-withlabels" multiple="multiple">
                                            <optgroup label="Mathematics">
                                                <option value="analysis">Analysis</option>
                                                <option value="discrete">Discrete Mathematics</option>
                                                <option value="probability">Probability Theory</option>
                                            </optgroup>
                                            <optgroup label="Computer Science">
                                                <option value="programming">Introduction to Programming</option>
                                                <option value="automata">Automata Theory</option>
                                                <option value="complexity">Complexity Theory</option>
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <select id="multiselect8" multiple="multiple">
                                            <option value="cheese">Cheese</option>
                                            <option value="tomatoes">Tomatoes</option>
                                            <option value="mozarella">Mozzarella</option>
                                            <option value="mushrooms">Mushrooms</option>
                                            <option value="pepperoni">Pepperoni</option>
                                            <option value="onions">Onions</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>

            <!-- DEFAULT CHECKBOXES -->
            <div class="panel">
                <div class="panel-heading">
                    <span class="panel-title">Default Inputs</span>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Radios</label>
                            <div class="col-md-9">
                                <label class="radio-inline mr10">
                                    <input type="radio" name="inlineRadioOptions" id="inlineRadio1"
                                        value="option1">1</label>
                                <label class="radio-inline mr10">
                                    <input type="radio" name="inlineRadioOptions" id="inlineRadio2"
                                        value="option2">2</label>
                                <label class="radio-inline mr10">
                                    <input type="radio" name="inlineRadioOptions" id="inlineRadio3"
                                        value="option3">3</label>
                                <label class="radio-inline mr10">
                                    <input type="radio" name="inlineRadioOptions" id="inlineRadio4"
                                        value="option4">4</label>
                                <label class="radio-inline mr10">
                                    <input type="radio" name="inlineRadioOptions" id="inlineRadio5"
                                        value="option5">5</label>
                            </div>
                        </div>
                        <div class="form-group mb25">
                            <label class="col-md-3 control-label">Checkboxes</label>
                            <div class="col-md-9">
                                <label class="checkbox-inline mr10">
                                    <input type="checkbox" id="inlineCheckbox1" value="option1">1</label>
                                <label class="checkbox-inline mr10">
                                    <input type="checkbox" id="inlineCheckbox2" value="option2">2</label>
                                <label class="checkbox-inline mr10">
                                    <input type="checkbox" id="inlineCheckbox3" value="option3">3</label>
                                <label class="checkbox-inline mr10">
                                    <input type="checkbox" id="inlineCheckbox4" value="option4">4</label>
                                <label class="checkbox-inline mr10">
                                    <input type="checkbox" id="inlineCheckbox5" value="option5">5</label>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>

    </div>


@endsection
