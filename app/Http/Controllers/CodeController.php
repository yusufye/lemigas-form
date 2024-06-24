<?php

namespace App\Http\Controllers;

use App\Models\Code;
use App\Models\PublicForm;
use Illuminate\Support\Facades\Crypt;

class CodeController extends Controller
{
    public function show(Code $code)
    {
        $encryptedCodeId = Crypt::encryptString($code->id);
        $form=PublicForm::where('code_id',$code->id)->get()->first();
        return view('public.form', ['code' => $code,'encryptedCodeId'=>$encryptedCodeId,'form'=>($form)?$form:[]]);
    }
}
