{{----------------------------
| Bridging Group Create Form
----------------------------}}
{!! Form::open(['name'=>'dockingGroupSetup-form','id'=>'dockingGroupSetup-form','route'=>['sendDockingGroupRequest'],'method'=>'post','data-toggle'=>'validator']) !!}

<div class="uiBox uiBox--md">

    <div class="uiBox__body">
        <h4 class="text-center">Invite a Group</h4>

        {{----------------------------
        | Check Session
        ----------------------------}}
        @include('templates.session.checkSession')
        @include('templates.session.checkSession-errorList')


        {{----------------------------
        | Choose one of your group
        ----------------------------}}
        <div class="form-group form-prepend form-prepend-label mB--xxlg">
            {!! Form::label('my_groups','Choose one of your group:') !!}
            <select name="source_group_id" id="my_groups" class="form-control" required="required">
                @foreach(Auth::user()->groups as $source_group)
                    @if ((validate_currentUser_has_permission($source_group->id)))
                        @if ( !($source_group->id == $target_group->id))
                            <option value="{{ $source_group->id }}">{{ $source_group->name }}</option>
                        @endif
                    @endif
                @endforeach
            </select>
            <span class="form-prepend-item icon icon-group"></span>
            <div class="help-block with-errors"></div>
            <div class="text-light small mT">Notes: You can only send the bridging request when you are the group admin.</div>
        </div>

        {{----------------------------
        | Target Group Infomation
        ----------------------------}}
        {!! Form::label('target_group_info','Bridging with following group:') !!}
        <div id="target_group_info" class="uiCard mB--md mB--xxlg">
            <div class="uiCard__body">
                <div class="uiCard__content">
                    <div class="sgp-left__group__name">
                        <a href="{{ url_link_to_group($target_group->id) }}" class="lk-darker">
                            {{$target_group->name}}
                        </a>
                    </div>
                    <input type="hidden" name="target_group_id" value="{{ $target_group->id }}">
                    <div class="sgp-left__group__description small mB--md break-word">
                        {{$target_group->description}}
                    </div>
                    <div class="small text-light text-overflow">
                        <span class="icon icon-category mR"></span>
                        {{ getGroupTypeName($target_group) }}
                    </div>
                </div>
            </div>
        </div>

        {{----------------------------
        | Bridging Group Name
        ----------------------------}}
        <div class="form-group form-prepend form-prepend-label mB--xxlg">
            {!! Form::label('docking_group_name','Enter a bridging name:') !!}
            {!! Form::text('docking_group_name',null,['class'=>'form-control','placeholder'=>'Bridging Name', 'data-minlength'=>'3','data-minlength-error'=>'Minimum of 3 characters', 'required']) !!}
            <span class="form-prepend-item icon icon-identity"></span>
            <div class="help-block with-errors"></div>
        </div>

        {{----------------------------
        | Make Group Private
        ----------------------------}}
        <div class="form-group form-prepend">
            <label for="privacy_rule_id">Group Privacy Setting: </label>
            <br>
            @foreach(App\Models\PrivacyRule::all() as $privacyRule)
                <div class="mR inline-block">
                    <label class="label-md radio-inline">
                        <input type="radio" name="privacy_rule_id" value="{{ $privacyRule->id }}" required>
                        {{ $privacyRule->rule_description }}
                    </label>
                </div>
            @endforeach
        </div>

        {{----------------------------
        | Accept Agreement
        | TODO: insert agreement
        ----------------------------}}
        <div class="form-group">
            <label class="label-md-light checkbox-uncheck">
                {!! Form::checkbox('agreement','yes',['required','false']) !!}
                I have read and accepted <a href="#">Agreement</a>
            </label>
        </div>

    </div>

    <div class="uiBox__footer text-center uiBox__footer__btn">
        {{----------------------------
        | Submit button
        ----------------------------}}
        {!! Form::submit('Send Request',['class'=>'btn-primary btn-block']) !!}
    </div>

</div>
{!! Form::close() !!}