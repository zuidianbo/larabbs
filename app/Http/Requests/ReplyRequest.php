<?php

namespace App\Http\Requests;

class ReplyRequest extends Request
{
//    public function rules()
//    {
//        switch($this->method())
//        {
//            // CREATE
//            case 'POST':
//            {
//                return [
//                    // CREATE ROLES
//                ];
//            }
//            // UPDATE
//            case 'PUT':
//            case 'PATCH':
//            {
//                return [
//                    // UPDATE ROLES
//                ];
//            }
//            case 'GET':
//            case 'DELETE':
//            default:
//            {
//                return [];
//            }
//        }
//    }


    public function rules()
    {
        return [
            'content' => 'required|min:2',
        ];
    }


    public function messages()
    {
        return [
            // Validation messages
            'content.required' => '回复内容是不为空的',
            'content.min' => '回复的长度至少为2',
        ];
    }
}
