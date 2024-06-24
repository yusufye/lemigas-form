<?php

namespace App\Http\Controllers;

use App\Models\Code;
use App\Models\PublicForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class PublicFormController extends Controller
{
    public function store(Request $request, $encryptedCodeId)
    {
        
            // Dekripsi code_id dari URL
            $decryptedCodeId = Crypt::decryptString($encryptedCodeId);
            
    
            // Validasi jika code_id dari URL tidak cocok dengan code_id dari form
            if ($decryptedCodeId !== $request->input('code_id')) {
                return redirect()->back()->withErrors(['code_id' => 'Invalid code.']);
            }
    
            // Lakukan validasi data form
            $rules = [
                'code_id' => 'required|integer|unique:public_forms',
                'signature_pad' => 'required',
            ];
            for ($i = 1; $i <= 9; $i++) {
                $rules["kepentingan_{$i}"] = 'required|integer|in:1,2,3,4';
                $rules["kepuasan_{$i}"] = 'required|integer|in:1,2,3,4';
                $rules["korupsi_{$i}"] = 'required|integer|in:1,2,3,4';
            }

            $validatedData = $request->validate($rules);
            // dd($validatedData);
            
            // try {
            $code=Code::all()->find($decryptedCodeId);
            
            $data['code_id']         = $decryptedCodeId;
            $data['submitted_at']    = date('Y-m-d H:i:s');
            $data['company_name']    = $request->company_name;
            $data['company_address'] = $request->company_address;
            $data['company_phone']   = $request->company_phone;
            $data['remark']          = $request->remark;

            for ($i = 1; $i <= 9; $i++) {
                $data["kepentingan_{$i}"] = $request->input("kepentingan_{$i}");
                $data["kepuasan_{$i}"]    = $request->input("kepuasan_{$i}");
                $data["korupsi_{$i}"]     = $request->input("korupsi_{$i}");
            }

            // Ambil data gambar base64 dari request
            $imageData = $request->signature_pad;

            // Pisahkan data gambar base64 dari jenis dan encoding
            $exploded = explode(',', $imageData);

            // Ambil jenis gambar (png, jpeg, dll)
            $imageType = explode(';', $exploded[0])[0];

            // Simpan data gambar sebagai file
            $imagePath = 'signatures/' .$code->code.'_'. time() . '.' . str_replace('data:image/', '', $imageType);
            Storage::disk('public')->put($imagePath, base64_decode($exploded[1]));
    
            // Tambahkan path gambar tanda tangan ke dalam $data
            $data['signature_path'] = $imagePath;

            
            // dd($data);
            $publicForm=PublicForm::create($data);

            $form=PublicForm::where('code_id',$code->id)->get()->first();
    

            // return redirect()->route('public-form', [
            //     'code' => $code,
            //     'encryptedCodeId'=>$encryptedCodeId,
            //     'form'=>($form)?$form:[]])->with('success', 'Form has been submitted successfully.');
    
            return view('public/success', [
                'encryptedCodeId' => $encryptedCodeId
            ]);

            
            // return redirect()->route('public-form',[
            //     'code' => $code,
            //     'encryptedCodeId' => $encryptedCodeId,
            //     'form' => ($form)?$form:[],
            //     'success' => 'Form has been submitted successfully.'
            // ]);

            // } catch (\Exception $e) {
            //     return redirect()->back()->withErrors(['code_id' => 'Submitting Form Failed']);
            // }

        // return redirect()->route('public-form.show', ['encryptedId' => $encryptedId]);
 
    }
}
