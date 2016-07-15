{{----------------------------
| Edit Bridging Group Form
----------------------------}}
<div class="uiCards">
    <div class="uiCard">

        <div class="uiCard__body">
            {{----------------------------
            | Nav
            ----------------------------}}
            <div class="uiCard__nav clearfix">
                <ul class="list-inline pull-left uiTabs__nav">
                    <li class="active">
                        <a href="#tabs-1" data-toggle="tab" class="lk-d lk-block">Edit Infomation</a>
                    </li>
                </ul>
            </div>

            <div id="tabs-1" class="uiCard__content uiTabs__content active">

                {!! Form::model($dockingGroup, ['route'=> ['dockingGroup-edit', 'dockingGroup_id' => $dockingGroup->id], 'method'=>'patch','id'=>'dockingGroup-disband', 'role'=>'form'])!!}

                {{----------------------------
                | Check Session
                ----------------------------}}
                @include('templates.session.checkSession')
                @include('templates.session.checkSession-errorList')

                {{----------------------------
                 | Bridging Group Name
                 ----------------------------}}
                <div class="form-group form-prepend form-prepend-label mB--lg">
                    {!! Form::label('docking_group_name','Enter a bridging name:') !!}
                    {!! Form::text('docking_group_name',null,['class'=>'form-control','placeholder'=>'Bridging Name', 'data-minlength'=>'3','data-minlength-error'=>'Minimum of 3 characters', 'required']) !!}
                    <span class="form-prepend-item icon icon-identity"></span>
                    <div class="help-block with-errors"></div>
                </div>

                {{----------------------------
                | Make Bridging Group Private
                ----------------------------}}
                <div class="form-group form-prepend">
                    <label for="privacy_rule_id">Group Privacy Setting: </label>
                    <br>
                    @foreach(App\Models\PrivacyRule::all() as $privacyRule)
                        <div class="mR inline-block">
                            <label class="label-md radio-inline">
                                @if($dockingGroup->privacy_rule_id == $privacyRule->id)
                                    <input type="radio" name="privacy_rule_id" value="{{ $dockingGroup->privacy_rule_id }}" checked>
                                    {{ $dockingGroup->privacyRule()->firstOrFail()->rule_description }}
                                @else
                                    <input type="radio" name="privacy_rule_id" value="{{ $privacyRule->id }}" required>
                                    {{ $privacyRule->rule_description }}
                                @endif
                            </label>
                        </div>
                    @endforeach
                </div>
                {{----------------------------
                | Submit button
                ----------------------------}}
                {!! Form::submit('Update',['class'=>'btn btn-primary btn-block']) !!}

                {!!  Form::close() !!}

            </div>
        </div>
    </div>
</div>