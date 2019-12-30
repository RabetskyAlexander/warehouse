<?php

namespace App\Http\Controllers;

use App\Models\Code;
use App\Repositories\CodeRepository;
use Illuminate\Http\Request;

class CodeController extends Controller
{

    /** @var  CodeRepository */
    private $codeRepository;

    public function __construct(CodeRepository $codeRepository)
    {
        $this->codeRepository = $codeRepository;
    }

    public function search(Request $request)
    {
        $message = [];
        $data = $this->validate($request,
            [
                'term' => 'required|string|max:255',
            ],
            $message
        );
        return $this->codeRepository->searchByName($data['term']);
    }

    public function add(Request $request)
    {
        if ($request->isMethod('post')) {
            $message = [];
            $data = $this->validate($request,
                [
                    'name' => 'required|string|max:255',
                    'manufacture_id' => 'required|integer',
                ],
                $message
            );
            $code = $this->codeRepository->add($data['name'], $data['manufacture_id']);
            return redirect('/codes/view/' . $code->id);
        } else {
            return view('code.add');
        }
    }

    public function view($code_id)
    {
        return view('code.view')->with(['code' => Code::query()->findOrFail($code_id)]);
    }
}
