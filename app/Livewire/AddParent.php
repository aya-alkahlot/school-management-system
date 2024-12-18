<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Religion;
use App\Models\My_Parent;
use App\Models\Type_Blood;
use App\Models\Nationalitie;
use Livewire\Attributes\Url;
use Livewire\WithFileUploads;
use App\Models\ParentAttachment;
use Illuminate\Support\Facades\Hash;


class AddParent extends Component
{
    // #[Url]
    use WithFileUploads;

    public $successMessage = '';
    public $catchError, $updateMode = false, $photos, $show_table = true, $Parent_id;
    public $currentStep = 1;

    // Father Inputs
    public $Email, $Password, $Name_Father, $Name_Father_en, $Job_Father, $Job_Father_en;
    public $National_ID_Father, $Passport_ID_Father, $Phone_Father, $Nationality_Father_id;
    public $Blood_Type_Father_id, $Religion_Father_id, $Address_Father;

    // Mother Inputs
    public $Name_Mother, $Name_Mother_en, $Job_Mother, $Job_Mother_en;
    public $National_ID_Mother, $Passport_ID_Mother, $Phone_Mother, $Nationality_Mother_id;
    public $Blood_Type_Mother_id, $Religion_Mother_id, $Address_Mother;


    // public function updated($propertyName)
    // {
    //     $this->validateOnly($propertyName, [
    //         'Email' => 'required|email',
    //         'National_ID_Father' => 'required|string|min:10|max:10|regex:/[0-9]{9}/',
    //         'Passport_ID_Father' => 'min:10|max:10',
    //         'Phone_Father' => 'regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
    //         'National_ID_Mother' => 'required|string|min:10|max:10|regex:/[0-9]{9}/',
    //         'Passport_ID_Mother' => 'min:10|max:10',
    //         'Phone_Mother' => 'regex:/^([0-9\s\-\+\(\)]*)$/|min:10'
        
    //         // 'Email' => 'required|email',
    //         // 'National_ID_Father' => 'required|string|min:10|max:10|regex:/[0-9]{9}/',
    //         // 'Passport_ID_Father' => 'nullable|min:10|max:10',
    //         // 'Phone_Father' => 'nullable|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
    //         // 'Nationality_Father_id' => 'required|exists:nationalities,id',
    //         // 'Blood_Type_Father_id' => 'required|exists:type_bloods,id',
    //         // 'Religion_Father_id' => 'required|exists:religions,id',
    //         // 'Address_Father' => 'required|string|max:500',
    
    //         // 'Name_Mother' => 'required|string|max:255',
    //         // 'National_ID_Mother' => 'required|string|min:10|max:10|regex:/[0-9]{9}/',
    //         // 'Passport_ID_Mother' => 'nullable|min:10|max:10',
    //         // 'Phone_Mother' => 'nullable|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
    //         // 'Nationality_Mother_id' => 'required|exists:nationalities,id',
    //         // 'Blood_Type_Mother_id' => 'required|exists:type_bloods,id',
    //         // 'Religion_Mother_id' => 'required|exists:religions,id',
    //         // 'Address_Mother' => 'required|string|max:500',
        
        
    //     ]);
    // }


    public function render()
    {
        return view('livewire.add-parent', [
            'Nationalities' => Nationalitie::all(),
            'Type_Bloods' => Type_Blood::all(),
            'Religions' => Religion::all(),
            'my_parents' => My_Parent::all(),
        ]);
    }

    public function showformadd(){
        $this->show_table = false;
    }

    public function firstStepSubmit()
    {
        $this->validate([
            'Email' => 'required|email',
            //    'Password' => 'required|min:6',
            //    'Name_Father' => 'required|string|max:255',
            //    'Name_Father_en' => 'required|string|max:255',
            //    'Job_Father' => 'required|string|max:255',
            //    'Job_Father_en' => 'required|string|max:255',
            //    'National_ID_Father' => 'required|numeric|unique:my_parents,National_ID_Father',
            //    'Passport_ID_Father' => 'required|string|max:255',
            //    'Phone_Father' => 'required|numeric|digits_between:10,15',
            //    'Nationality_Father_id' => 'required|exists:nationalities,id',
            //    'Blood_Type_Father_id' => 'required|exists:type_bloods,id',
            //    'Religion_Father_id' => 'required|exists:religions,id',
            //    'Address_Father' => 'required|string|max:500',
        ]);

        $this->currentStep = 2;
    }


    public function secondStepSubmit()
    {
        $this->validate([
            'Name_Mother' => 'required|string|max:255',
            // 'Name_Mother_en' => 'required|string|max:255',
            // 'Job_Mother' => 'required|string|max:255',
            // 'Job_Mother_en' => 'required|string|max:255',
            // 'National_ID_Mother' => 'required|numeric|unique:my_parents,National_ID_Mother',
            // 'Passport_ID_Mother' => 'required|string|max:255',
            // 'Phone_Mother' => 'required|numeric|digits_between:10,15',
            // 'Nationality_Mother_id' => 'required|exists:nationalities,id',
            // 'Blood_Type_Mother_id' => 'required|exists:type_bloods,id',
            // 'Religion_Mother_id' => 'required|exists:religions,id',
            // 'Address_Mother' => 'required|string|max:500',
        ]);

        $this->currentStep = 3;
    }

    public function submitForm(){

        try {
            $My_Parent = new My_Parent();
            // Father_INPUTS
            $My_Parent->Email = $this->Email;
            $My_Parent->Password = Hash::make($this->Password);
            $My_Parent->Name_Father = ['en' => $this->Name_Father_en, 'ar' => $this->Name_Father];
            $My_Parent->National_ID_Father = $this->National_ID_Father;
            $My_Parent->Passport_ID_Father = $this->Passport_ID_Father;
            $My_Parent->Phone_Father = $this->Phone_Father;
            $My_Parent->Job_Father = ['en' => $this->Job_Father_en, 'ar' => $this->Job_Father];
            $My_Parent->Passport_ID_Father = $this->Passport_ID_Father;
            $My_Parent->Nationality_Father_id = $this->Nationality_Father_id;
            $My_Parent->Blood_Type_Father_id = $this->Blood_Type_Father_id;
            $My_Parent->Religion_Father_id = $this->Religion_Father_id;
            $My_Parent->Address_Father = $this->Address_Father;

            // Mother_INPUTS
            $My_Parent->Name_Mother = ['en' => $this->Name_Mother_en, 'ar' => $this->Name_Mother];
            $My_Parent->National_ID_Mother = $this->National_ID_Mother;
            $My_Parent->Passport_ID_Mother = $this->Passport_ID_Mother;
            $My_Parent->Phone_Mother = $this->Phone_Mother;
            $My_Parent->Job_Mother = ['en' => $this->Job_Mother_en, 'ar' => $this->Job_Mother];
            $My_Parent->Passport_ID_Mother = $this->Passport_ID_Mother;
            $My_Parent->Nationality_Mother_id = $this->Nationality_Mother_id;
            $My_Parent->Blood_Type_Mother_id = $this->Blood_Type_Mother_id;
            $My_Parent->Religion_Mother_id = $this->Religion_Mother_id;
            $My_Parent->Address_Mother = $this->Address_Mother;
            $My_Parent->save();

            if (!empty($this->photos)){
                foreach ($this->photos as $photo) {
                    $photo->storeAs($this->National_ID_Father, $photo->getClientOriginalName(), $disk = 'parent_attachments');
                    ParentAttachment::create([
                        'file_name' => $photo->getClientOriginalName(),
                        'parent_id' => My_Parent::latest()->first()->id,
                    ]);
                }
            }
            $this->successMessage = trans('messages.success');
            $this->clearForm();
            $this->currentStep = 1;
        }

        catch (\Exception $e) {
            $this->catchError = $e->getMessage();
        };

    }


    public function edit($id)
    {
        $this->show_table = false;
        $this->updateMode = true;
        $My_Parent = My_Parent::where('id',$id)->first();
        $this->Parent_id = $id;
        $this->Email = $My_Parent->Email;
        $this->Password = $My_Parent->Password;
        $this->Name_Father = $My_Parent->getTranslation('Name_Father', 'ar');
        $this->Name_Father_en = $My_Parent->getTranslation('Name_Father', 'en');
        $this->Job_Father = $My_Parent->getTranslation('Job_Father', 'ar');;
        $this->Job_Father_en = $My_Parent->getTranslation('Job_Father', 'en');
        $this->National_ID_Father =$My_Parent->National_ID_Father;
        $this->Passport_ID_Father = $My_Parent->Passport_ID_Father;
        $this->Phone_Father = $My_Parent->Phone_Father;
        $this->Nationality_Father_id = $My_Parent->Nationality_Father_id;
        $this->Blood_Type_Father_id = $My_Parent->Blood_Type_Father_id;
        $this->Address_Father =$My_Parent->Address_Father;
        $this->Religion_Father_id =$My_Parent->Religion_Father_id;

        $this->Name_Mother = $My_Parent->getTranslation('Name_Mother', 'ar');
        $this->Name_Mother_en = $My_Parent->getTranslation('Name_Father', 'en');
        $this->Job_Mother = $My_Parent->getTranslation('Job_Mother', 'ar');;
        $this->Job_Mother_en = $My_Parent->getTranslation('Job_Mother', 'en');
        $this->National_ID_Mother =$My_Parent->National_ID_Mother;
        $this->Passport_ID_Mother = $My_Parent->Passport_ID_Mother;
        $this->Phone_Mother = $My_Parent->Phone_Mother;
        $this->Nationality_Mother_id = $My_Parent->Nationality_Mother_id;
        $this->Blood_Type_Mother_id = $My_Parent->Blood_Type_Mother_id;
        $this->Address_Mother =$My_Parent->Address_Mother;
        $this->Religion_Mother_id =$My_Parent->Religion_Mother_id;
    }

    //firstStepSubmit
    public function firstStepSubmit_edit()
    {
        $this->updateMode = true;
        $this->currentStep = 2;

    }

    //secondStepSubmit_edit
    public function secondStepSubmit_edit()
    {
        $this->updateMode = true;
        $this->currentStep = 3;

    }

    public function submitForm_edit(){

        if ($this->Parent_id){
            $parent = My_Parent::find($this->Parent_id);
            $parent->update([
                'Email' => $this->Email,
                'Password' => $this->Password,
                'Name_Father' => $this->Name_Father,
                // 'Name_Father_en' => $this->Name_Father_en,
                'Job_Father' => $this->Job_Father,
                // 'Job_Father_en' => $this->Job_Father_en,
                'Passport_ID_Father' => $this->Passport_ID_Father,
                'National_ID_Father' => $this->National_ID_Father,
                'Phone_Father' => $this->Phone_Father,
                'Nationality_Father_id' => $this->Nationality_Father_id,
                'Blood_Type_Father_id' => $this->Blood_Type_Father_id,
                'Religion_Father_id' => $this->Religion_Father_id,
                'Address_Father' => $this->Address_Father,


                'Name_Mother' => $this->Name_Mother,
                // 'Name_Mother_en' => $this->Name_Mother_en,
                'Job_Mother' => $this->Job_Mother,
                // 'Job_Mother_en' => $this->Job_Mother_en,
                'National_ID_Mother' => $this->National_ID_Mother,
                'Passport_ID_Mother' => $this->Passport_ID_Mother,
                'Phone_Mother' => $this->Phone_Mother,
                'Nationality_Mother_id' => $this->Nationality_Mother_id,
                'Blood_Type_Mother_id' => $this->Blood_Type_Mother_id,
                'Address_Mother' => $this->Address_Mother,
                'Religion_Mother_id' => $this->Religion_Mother_id,

            ]);

        }

        return redirect()->to('/add_parent');
    }

    public function delete($id){
        My_Parent::findOrFail($id)->delete();
        return redirect()->to('/add_parent');
    }


    //clearForm
    public function clearForm()
    {
        $this->Email = '';
        $this->Password = '';
        $this->Name_Father = '';
        $this->Job_Father = '';
        $this->Job_Father_en = '';
        $this->Name_Father_en = '';
        $this->National_ID_Father ='';
        $this->Passport_ID_Father = '';
        $this->Phone_Father = '';
        $this->Nationality_Father_id = '';
        $this->Blood_Type_Father_id = '';
        $this->Address_Father ='';
        $this->Religion_Father_id ='';

        $this->Name_Mother = '';
        $this->Job_Mother = '';
        $this->Job_Mother_en = '';
        $this->Name_Mother_en = '';
        $this->National_ID_Mother ='';
        $this->Passport_ID_Mother = '';
        $this->Phone_Mother = '';
        $this->Nationality_Mother_id = '';
        $this->Blood_Type_Mother_id = '';
        $this->Address_Mother ='';
        $this->Religion_Mother_id ='';

    }


    //back
    public function back($step)
    {
        $this->currentStep = $step;
    }

}