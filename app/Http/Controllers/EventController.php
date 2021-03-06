<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use App\Product;
use App\Partner;
use App\Category;

Use Storage;


class EventController extends Controller
{
    
    protected $paginate = 5;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = Event::orderBy('date', 'desc')->paginate($this->paginate);

        return view('back.index', ['events' => $events]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $categories = Category::pluck('titre', 'id')->all();

        return view('back.create-event', [ 'categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $this->validate($request, [
            'titre' => 'required',
            'description' => 'required|string',
            'status' => 'in:Publié,Brouillon',
            'prix' => 'required',
            'promo' => 'required',
             'date' => "required|date:Y-m-d",
            'category_id' => 'integer',
            'form' => 'required|string',
            'picture' => 'image|dimensions:max_width=1200,max_height=900', 
        ]);
        $event = Event::create($request->all());
        
        $im = $request->file('picture');
        if (!empty($im)) {
            
            $link = $request->file('picture')->store('');

            // mettre à jour la table picture pour le lien vers l'image dans la base de données
            $event->pictureEvent()->create([
                'url_img_event' => $link,
                'titre' => 'default'
            ]);
        }

        return redirect()->route('event.index')->with('message-success', 'Évènement créé avec succès !');  ;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $event = Event::find($id);

         return view('back.show-event', ['event' => $event]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $event = Event::find($id);

      
        $categories = Category::pluck('titre', 'id')->all();

        return view('back.edit-event', compact('event', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'titre' => 'required',
            'description' => 'required|string',
            'status' => 'in:Publié,Brouillon',
            'prix' => 'required',
            'promo' => 'required',
            'date' => "required|date:Y-m-d",
            'category_id' => 'integer',
            'form' => 'required|string',
            'picture' => 'image|dimensions:max_width=1200,max_height=900',
        ]);
        $event = Event::find($id); // associé les fillables

        $event->update($request->all());
        
        // image
        $im = $request->file('picture');
        
        // si on associe une image à un event 
        if (!empty($im)) {

            $link = $request->file('picture')->store('');

            // suppression de l'image si elle existe 
            if(count($event->pictureEvent)>0){
                Storage::disk('local')->delete($event->pictureEvent->url_img_event); // supprimer physiquement l'image
                $event->pictureEvent()->delete(); // supprimer l'information en base de données
            }

            // mettre à jour la table picture pour le lien vers l'image dans la base de données
            $event->pictureEvent()->create([
                'url_img_event' => $link,
                'titre' => 'default'
            ]);
            
        }

        return redirect()->route('event.index')->with('message-success', 'Évènement édité avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $event = Event::where('id',$id)->firstOrFail();

        $event->delete();

        return redirect()->route('event.index')->with('message-danger', 'Supprimé sans sommation !'); 
    }
}
