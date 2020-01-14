<?php

namespace App\Http\Controllers\Api\Articles;

use App\Repositories\Eloquent\Admin\Articles\NoteRepository;
use App\Http\Controllers\Api\CommonController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiNoteController extends CommonController
{
    /**
     * 备忘录
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //获取某月所有备忘录
    private $note;
    function __construct(NoteRepository $note)
    {
        $this->note = $note;

    }
    //获取单日日记
    public  function getNote($date){
        $data = $this->note->getDayNote($date);
        return $this->response($data,'获取成功','200');
    }
    //获取当月有日记的时间
    public  function getMonthNote($year,$month){
        $data = $this->note->getMonthNote($year,$month);
        return $this->response($data,'获取成功','200');
    }
    //添加日记
    public function addNote(Request $request){
        $data = $request->all();
        $data['data']['user_id'] = Auth::user()->id;
        $this->note->createNote($data['data']);
        return $this->response('','日记添加成功','200');
    }
}
