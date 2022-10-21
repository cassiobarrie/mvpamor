<?php

namespace App\Http\Controllers;
use App\Models\Imagens;
use Illuminate\Http\Request;

class ImagensController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $imagens = Imagens::latest()->paginate(5);

        return view('imagens.index',compact('imagens'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('imagens.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'detail' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $input = $request->all();

        if ($image = $request->file('image')) {
            $destinationPath = 'images/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['image'] = "$profileImage";
        }

        Imagens::create($input);

        return redirect()->route('imagens.index')
                        ->with('Sucesso','Foto adicionada com secesso.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Imagens  $imagem
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $imagem = Imagens::find($id);
        return view('imagens.show',compact('imagem'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Imagens  $imagem
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $imagem = Imagens::find($id);
        return view('imagens.edit',compact('imagem'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Imagens  $imagem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $imagem = Imagens::find($id);
        $request->validate([
            'name' => 'required',
            'detail' => 'required'
        ]);

        $input = $request->all();

        if ($image = $request->file('image')) {
            $destinationPath = 'images/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['image'] = "$profileImage";
        }else{
            unset($input['image']);
        }

        $imagem->update($input);

        return redirect()->route('imagens.index')
                        ->with('Sucesso','Foto atualizada com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Imagens  $imagem
     * @param  \App\Http\Controllers\Imagens;
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $imagem = Imagens::find($id);
        $imagem->delete();

        return redirect()->route('imagens.index')
                        ->with('Sucesso','Foto deletada com sucesso.');
    }
}

