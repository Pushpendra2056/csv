<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use DB;
use session;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\IReadFilter;


class FromController extends Controller
{
    public function index(){
        return view('form');
    }

    public function data(Request $request){
       //dd($request->all());
       //$request->session()->put('username',null);
       //session()->put(['useremail'=>$request->email]);
        //if($request->session()->exists('username')){
        //    echo 'hello';
        ///}else{
///echo "get";
        //}
        ///has ,exists missing

       //$request->session()->decrement('count');

        //$request->session()->forget('username');
        $request->session()->flush();
    }

    public function viewStudent(){
        $student = DB::table('student')->get();
        return view('student-view',compact('student'));
    }

    public function delete($id){
        // Eloquent ORM Method
        //$table = Student::where('id',$id)->delete();

        // Query Builder Method
        $table = DB::table('student')->where('id',$id)->delete();
        if($table){
            return redirect()->back();
        }else{
            echo "have an issue";
        }
    }
    public function edit($id){
        // Eloquent ORM Method
        $selectData = Student::where('id',$id)->get();
        return view('editform',compact('selectData'));
    }

    public function editSubmit(Request $request){
        echo re($request);
        die();
        // Eloquent ORM Method
        // $select = Student::where('id',$request->id)->first();
        // $select->name = $request->name;
        // $select->email = $request->email;
        // $select->number = $request->number;
        // if($select->save()){
        //     return redirect()->back();
        // }else{
        //     echo "have an issue";
        // }

        // Query builder
        $select = DB::table('student')->where('id',$request->id)->update(['name'=> $request->name,'email' => $request->email, 'number' => $request->number]);
        if($select){
            return redirect()->back();
        }else{
            echo "have an issue";
        }
    }


    function mainFunction(Request $request){
        $file_path = 'DUMP.xlsx';
        $spreadsheet = IOFactory::load($file_path);
        $worksheet = $spreadsheet->getActiveSheet();
        foreach ($worksheet->getRowIterator() as $row) {
            foreach ($row->getCellIterator() as $cell) {
                //dd($cell);
                $cell_value = $cell->getValue();
                echo $cell_value;
            }
            echo "<br>";
        }

        // Get the value of a specific cell by name
        $cell_value = $worksheet->getCell('A1')->getValue();

        
        echo "<br>".$cell_value."<br>";
    }

    public function csvFileImportForMovieTable(){
        $filePath = 'movies.csv';
        $reader = IOFactory::createReader('Csv');
        $spreadsheet = $reader->load($filePath);

        $worksheet = $spreadsheet->getActiveSheet();
        $data = $worksheet->toArray();
        foreach($data as $key => $val){
            if($val[0] != "tconst" && $val[1] != "titleType" && $val[2] != "primaryTitle" && $val[3] != "runtimeMinutes" && $val[4] != "genres"){
                
                $insert = DB::table('movies')->insert(['tconst'=>$val[0],'titleType'=>$val[1],'primaryTitle'=>$val[2],'runtimeMinutes'=>$val[3],'genres'=>$val[4]]);
                if($insert > 0){
                    echo $val[0]." ----- ".$val[1]." ----- ".$val[2]." ----- ".$val[3]." ----- ".$val[4]."<br><br>";
                }
            }
        }
    }

    public function csvFileImportForRatingsTable()
    {
        $filePath = 'ratings.csv';
        $reader = IOFactory::createReader('Csv');
        $spreadsheet = $reader->load($filePath);

        $worksheet = $spreadsheet->getActiveSheet();
        $data = $worksheet->toArray();
        foreach($data as $key => $val){
            if($val[0] != "tconst" && $val[1] != "averageRating" && $val[2] != "numVotes"){
                
                $insert = DB::table('ratings')->insert(['tconst'=>$val[0],'averageRating'=>$val[1],'numVotes'=>$val[2]]);
                if($insert > 0){
                    echo $val[0]." ----- ".$val[1]." ----- ".$val[2]."<br><br>";
                }
            }
        }
    }
}
