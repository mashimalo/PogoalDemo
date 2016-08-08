{{--@inject ('countries', 'App\Http\Utilities\Country')--}}
{{--@inject ('GroupCategories', 'App\Http\Utilities\GroupCategory')--}}

@include('templates.session.checkSession-errorList')

{{----------------------------
| Group Avatar
----------------------------}}
{!! Form::model($group,['name'=>'groupAvatarUpload-form','id'=>'groupAvatarUpload-form','route'=> ['uploadGroupAvatar',$group->id],'method'=>'POST', 'files' => true])!!}

<h4 class="mB--lg text-uppercase bolder">
    Avatar:
</h4>

<div class="wrap mB--xxlg">
    <label class="c-f-3">Preview:</label>
    <div class="c-f-9">
        @if ($group->group_avatar_large != null || strlen($group->group_avatar_large) > 0)
            <img src="{!! '/images/groupAvatar/'.$group->group_avatar_large !!}" class="avatar avatar--lg arc-sm">
        @else
            <img class="avatar avatar--lg arc-sm" src="{{ url('/assets/images/avatar.jpg') }}">
        @endif
    </div>
</div>

<div class="wrap">
    <label for="uploadImage" class="c-f-3">Upload a new avatar:</label>
    <div class="c-f-9">
        <div class="form-group form-control">
            {!! Form::file('uploadImage') !!}
        </div>
    </div>
</div>

{{----------------------------
| Submit button
----------------------------}}
<div class="text-right">
    {!! Form::submit('Save Avatar',['class'=>'btn btn-primary']) !!}
</div>

{!! Form::close() !!}

<div class="divider-h divider-h--light divider-h--xxlg"></div>

{{----------------------------
| Group Info
----------------------------}}
{!! Form::model($group,['name'=>'editGroup-form','id'=>'editGroup-form','route'=> ['singleGroupProfilePage-modify', $group_id],'method'=>'PATCH','data-toggle'=>'validator'])!!}

<h4 class="mB--lg text-uppercase bolder">
    Group Infomation:
</h4>

{{----------------------------
| Group Name Input
----------------------------}}
<div class="wrap">
    <div class="c-f-3">
        {!! Form::label('group_name','Group Name') !!}
    </div>
    <div class="c-f-9">
        <div class="form-group form-prepend">
            {!! Form::text('name', null, ['id'=>'group_name','class'=>'form-control','placeholder'=>'Group Name','required']) !!}
            <span class="form-prepend-item icon icon-group"></span>
            <div class="help-block with-errors"></div>
        </div>
    </div>
</div>

{{----------------------------
| Group Category Option
----------------------------}}
<div class="mB--lg">
    <div class="wrap">
        <div class="c-f-3">
            Group Category:
        </div>
        <div class="c-f-9">
            <div id="singleGroup-group-category" class="inline-block mR--md">
                <span id="singleGroup-group-category-selected" class="text-green text-uppercase bolder">{{ getGroupTypeName($group) }}</span>
            </div>
            <div id="singleGroup-group-category-button" class="btn btn-primary btn-square rounded link-fake text-xlg"
                 data-toggle="modal"
                 data-target="#singleGroup-group-category-modal" role="button">
                +
            </div>
            <div id="singleGroup-group-category-change-button" class="btn btn-blue btn-sm small"
                 style="display: none;"
                 data-toggle="modal"
                 data-target="#singleGroup-group-category-modal" role="button">
                Change
            </div>
        </div>
    </div>
</div>


{{----------------------------
| Group Category Modal
----------------------------}}
<div class="uiModal fade" id="singleGroup-group-category-modal">
    <div class="uiModal__dialog uiModal--md">
        <div class="uiModal__content">
            <div class="uiModal__header">
                <button class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
                <div class="h3 text-center">
                    Choose a Group Type
                </div>
            </div>
            <div class="uiModal__body pL--xxlg pR--xxlg mB--none">
                <div class="form-group">
                    <div class="wrap">
                        @foreach(App\Models\GroupType::all() as $groupType)
                            <div class="c-f-4 mB--md">
                                <label class="label-md-light radio-inline">
                                    @if($group->group_type_id == $groupType->id)
                                        <input type="radio" name="group_type_id" value="{{ $group->group_type_id }}" checked>
                                        {{ getGroupTypeName($group) }}
                                    @else
                                        <input type="radio" name="group_type_id" value="{{ $groupType->id }}" required>
                                        {{ $groupType->group_type_name }}
                                    @endif
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="uiModal__footer text-right">
                <button class="btn btn-primary" data-dismiss="modal">
                    Ok
                </button>
            </div>
        </div>
    </div>
</div>

{{----------------------------
| Bio
----------------------------}}
<div class="wrap">
    <div class="c-f-3">
        {!! Form::label('group_description','Group Description:') !!}
    </div>
    <div class="c-f-9">
        <div class="form-group form-prepend">
            {!! Form::textarea('description',null,['class'=>'form-control h--auto','placeholder'=>'Group description...']) !!}
            <span class="form-prepend-item icon icon-summary"></span>
        </div>
    </div>
</div>

{{----------------------------
| Make Group Private
----------------------------}}
<div class="wrap">
    <div class="c-f-3">
        <label for="privacy_rule_id">Group Privacy Setting: </label>
    </div>
    <div class="c-f-9">
        <div class="form-group form-prepend">
            @foreach(App\Models\PrivacyRule::all() as $privacyRule)
                <div class="mR">
                    <label class="label-md radio-inline">
                        @if($group->privacy_rule_id == $privacyRule->id)
                            <input type="radio" name="privacy_rule_id" value="{{ $group->privacy_rule_id }}" checked>
                            {{ $group->privacyRule()->firstOrFail()->rule_description }}
                        @else
                            <input type="radio" name="privacy_rule_id" value="{{ $privacyRule->id }}" required>
                            {{ $privacyRule->rule_description }}
                        @endif
                    </label>
                </div>
            @endforeach
        </div>
    </div>
</div>

{{----------------------------
| Submit button
----------------------------}}
<div class="text-right">
    {!! Form::submit('Update',['class'=>'btn btn-primary']) !!}
</div>

{!!  Form::close() !!}