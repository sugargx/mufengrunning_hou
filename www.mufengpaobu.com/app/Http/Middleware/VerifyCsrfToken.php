<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'story',//武志祥
        'image',//武志祥
        'findStory',//武志祥
        'equipment',//武志祥
        'equipmentImage',//武志祥
        'findEquipment',//武志祥
        'storyCheck',//武志祥
        'equipmentCheck',//武志祥
        'getNum',//武志祥
        'comment',//武志祥
        'reply',//武志祥
        'findMyEquipment',//武志祥
        'findMyStory',//武志祥
        'dashang',//武志祥

        'view',//张迪
        'uploadimg',
        'data',//张迪
        'upload',//张迪
        'getopenid',//张迪
        'runGroup',//张迪
        'allGroup',//张迪
        'teamIntroduce',//张迪
        'uploaduserinfo',//张迪
        'creatGroup',//张迪
        'applyGroup',//张迪
        'uploading',//张迪
        'uploadingUP',//张迪
        'upSuccess',//张迪
        'GroupAnalyse',//张迪
        'getMyGroupState',//张迪
        'getMyUploadFlag',//张迪
        'MyAnalyse',//张迪
        'test',//张迪
        'changeGroupInfo',//张迪

        'getApplicants',
        'agree',
        'noAgree',
        'getGroupPeo',
        'getGroupInfo',
        'changeGroupInfo1',
        'changeGroupInfo2',
        'creatAdv1',
        'creatAdv2',
        'creatAdv3',











        'viewUP',//张迪
        'uploadimgUP',
        'dataUP',//张迪
        'uploadUP',//张迪
        'getopenidUP',//张迪
        'runGroupUP',//张迪
        'allGroupUP',//张迪
        'teamIntroduceUP',//张迪
        'uploaduserinfoUP',//张迪
        'creatGroupUP',//张迪
        'applyGroupUP',//张迪
        'uploadingUP',//张迪
        'upSuccessUP',//张迪
        'GroupAnalyseUP',//张迪
        'getMyGroupStateUP',//张迪
        'getMyUploadFlagUP',//张迪
        'MyAnalyseUP',//张迪
        'testUP',//张迪
        'changeGroupInfoUP',//张迪
        'getApplicantsUP',
        'agreeUP',
        'noAgreeUP',
        'getGroupPeoUP',
        'getGroupInfoUP',
        'changeGroupInfo1UP',
        'changeGroupInfo2UP',
        'creatAdv1UP',
        'creatAdv2UP',
        'creatAdv3UP'
    ];
}
