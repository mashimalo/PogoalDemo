{{--@inject ('countries', 'App\Http\Utilities\Country')--}}
{{--@inject ('GroupCategories', 'App\Http\Utilities\GroupCategory')--}}

{!! Form::model($group,['name'=>'editGroup-form','id'=>'editGroup-form','route'=> ['singleGroupProfilePage-modify', $group_id],'method'=>'PATCH','data-toggle'=>'validator'])!!}

@include('templates.session.checkSession-errorList')

{{----------------------------
| Group Name Input
----------------------------}}
<div class="form-group form-prepend form-prepend-label">
    {!! Form::label('group_name','Group Name') !!}
    {!! Form::text('name', null, ['id'=>'group_name','class'=>'form-control','placeholder'=>'Group Name','required']) !!}
    <span class="form-prepend-item icon icon-group"></span>

    <div class="help-block with-errors"></div>
</div>

{{----------------------------
| Group Category Option
----------------------------}}
<div class="mB--lg">
    <div id="singleGroup-group-category" class="inline-block mR--md">
        <span class="bolder mR">Group Category:</span>
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


{{----------------------------
| Group Category Modal
| TODO: Injected $GroupTypes, see line 1
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
<div class="form-group form-prepend form-prepend-label">
    {!! Form::label('group_description','Group Description:') !!}
    {!! Form::textarea('description',null,['class'=>'form-control h--auto','placeholder'=>'Group description...']) !!}
    <span class="form-prepend-item icon icon-summary"></span>
</div>

{{----------------------------
| Make Group Private
----------------------------}}

<div class="form-group form-prepend">
    <label for="privacy_rule_id">Group Privacy Setting: </label>
    <br>
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
{{----------------------------
| Submit button
----------------------------}}
{!! Form::submit('Update',['class'=>'btn btn-primary btn-block']) !!}

{!!  Form::close() !!}

<div class="uiCard__content">
    <h2>Upload Avatar Here.</h2>
    <div class="container">
        {!! Form::model($group,['name'=>'groupAvatarUpload-form','id'=>'groupAvatarUpload-form','route'=> ['uploadGroupAvatar',$group->id],'method'=>'POST', 'files' => true])!!}
        <div class="form-group">
            {!! Form::label('uploadImage', 'Choose an image') !!}
            {!! Form::file('uploadImage') !!}
        </div>
        <div class="form-group">
            {!! Form::submit('Submit',['class'=>'btn btn-primary btn-block']) !!}
        </div>
        {!! Form::close() !!}
    </div>
    <h3> Large Avatar</h3>
    @if ($group->group_avatar_large != null || strlen($group->group_avatar_large) > 0)
        <img src= {!! '/images/groupAvatar/'.$group->group_avatar_large !!}>
    @endif

    <h3>Small Avatar</h3>
    @if ($group->group_avatar_small != null || strlen($group->group_avatar_small) > 0)
        <img src= {!! '/images/groupAvatar/'.$group->group_avatar_small !!}>
    @endif
</div>