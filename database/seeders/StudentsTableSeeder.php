<?php
namespace Database\Seeders;

use App\Models\Classroom;
use App\Models\Gender;
use App\Models\Grade;
use App\Models\My_Parent;
use App\Models\Nationalitie;
use App\Models\Section;
use App\Models\Student;
use App\Models\Type_Blood;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StudentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    // حذف البيانات القديمة
    DB::table('students')->delete();

    // إنشاء أكثر من طالب
    for ($i = 0; $i < 10; $i++) { // هنا قم بتحديد عدد الطلاب المطلوب (10 كمثال)
        $students = new Student();
        $students->name = [
            'ar' => 'طالب ' . $i,
            'en' => 'Student ' . $i
        ];
        $students->email = 'student' . $i . '@example.com'; // تغيير البريد الإلكتروني ليكون فريدًا
        $students->password = Hash::make('12345678');
        $students->gender_id = 1; // يمكنك تخصيص القيم أو جعلها عشوائية
        $students->nationalitie_id = Nationalitie::all()->unique()->random()->id;
        $students->blood_id = Type_Blood::all()->unique()->random()->id;
        $students->Date_Birth = date('1995-01-01'); // تعديل التاريخ حسب الحاجة
        $students->Grade_id = Grade::all()->unique()->random()->id;
        $students->Classroom_id = Classroom::all()->unique()->random()->id;
        $students->section_id = Section::all()->unique()->random()->id;
        $students->parent_id = My_Parent::all()->unique()->random()->id;
        $students->academic_year = '2021'; // تعديل العام الأكاديمي حسب الحاجة
        $students->save();
    }
}

}
