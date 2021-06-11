<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserProperty extends Model
{
    protected $fillable =[
        'user_id',
        'prop_key',
        'prop_value',
    ];

    public function getByUserID($uID){
        return $this->where('user_id', $uID)->orderBy('id', 'asc')->get();
    }


    public function createStudentProps($resStdDec, $id)
    {
        $this->createProp('RecordBookNumber', $resStdDec->RecordBookNumber, $id);
        $this->createProp('FullName_TJ', $resStdDec->FullName->TJ, $id);
        $this->createProp('FullName_RU', $resStdDec->FullName->RU, $id);
        $this->createProp('Faculty_TJ', $resStdDec->Faculty->TJ, $id);
        $this->createProp('Faculty_RU', $resStdDec->Faculty->RU, $id);
        $this->createProp('Specialty_TJ', $resStdDec->Specialty->TJ, $id);
        $this->createProp('Specialty_RU', $resStdDec->Specialty->RU, $id);
        $this->createProp('CodeSpecialty', $resStdDec->CodeSpecialty, $id);
        $this->createProp('TrainingForm', $resStdDec->TrainingForm, $id);
        $this->createProp('TrainingLevel', $resStdDec->TrainingLevel, $id);
        $this->createProp('Course', $resStdDec->Course, $id);
        $this->createProp('Group', $resStdDec->Group, $id);
        $this->createProp('YearUniversityEntrance', $resStdDec->YearUniversityEntrance, $id);
        $this->createProp('TrainingPeriod', $resStdDec->TrainingPeriod, $id);


    }


    public function updateStudentProps($resStdDec, $id)
    {
        $this->updateProp('RecordBookNumber', $resStdDec->RecordBookNumber, $id);
        $this->updateProp('FullName_TJ', $resStdDec->FullName->TJ, $id);
        $this->updateProp('FullName_RU', $resStdDec->FullName->RU, $id);
        $this->updateProp('Faculty_TJ', $resStdDec->Faculty->TJ, $id);
        $this->updateProp('Faculty_RU', $resStdDec->Faculty->RU, $id);
        $this->updateProp('Specialty_TJ', $resStdDec->Specialty->TJ, $id);
        $this->updateProp('Specialty_RU', $resStdDec->Specialty->RU, $id);
        $this->updateProp('CodeSpecialty', $resStdDec->CodeSpecialty, $id);
        $this->updateProp('TrainingForm', $resStdDec->TrainingForm, $id);
        $this->updateProp('TrainingLevel', $resStdDec->TrainingLevel, $id);
        $this->updateProp('Course', $resStdDec->Course, $id);
        $this->updateProp('Group', $resStdDec->Group, $id);
        $this->updateProp('YearUniversityEntrance', $resStdDec->YearUniversityEntrance, $id);
        $this->updateProp('TrainingPeriod', $resStdDec->TrainingPeriod, $id);


    }

    private function createProp($propName, $propVal, $uID){
        $usrP = new UserProperty();
        $usrP->user_id = $uID;
        $usrP->prop_key = $propName;
        $usrP->prop_value = $propVal;
        $usrP->save();
    }
    private function updateProp($propName, $propVal, $uID){
        $usrP = $this->where(['prop_key' => $propName, 'user_id'=>$uID])->get()->first();
        $usrP->prop_value = $propVal;
        $usrP->save();
    }
}
