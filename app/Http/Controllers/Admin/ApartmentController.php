<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Apartment;
use App\Service;
use App\Sponsorship;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(request $request)
    {
        $apartments = Apartment::where('user_id', Auth::user()->id)->orderByDesc("created_at")->get();
        return view('admin.apartments.index', compact('apartments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $services = Service::all();
        return view('admin.apartments.create', compact("services"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //valido i dati pervenuti lato-cliet
        $request->validate([
            "description_title" => "required|string|max:255",
            "cover_image" => "file|image|max:512",
            "description" => "nullable|min:50",
            "address" => "required|string",
            "lat" => ['required','regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'],
            "lon" => ['required','regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/'],
            "number_of_rooms" => "required|numeric|min:1|digits_between:1,11",
            "number_of_beds" => "required|numeric|min:1|digits_between:1,11",
            "number_of_bathrooms" => "required|numeric|min:1|digits_between:1,11",
            "square_meters" => "required|numeric|min:1|digits_between:1,11",
            "services" => "required"
        ]);
        //mappo i dati in un array
        $data= $request->all();
        //geenro uno slug
        $slug = Str::of($data['description_title'])->slug('-');
        $original_slug = $slug;
        $apartments = Apartment::where("slug", $slug)->first();
        $contatore = 0;
        while ($apartments) {
            $contatore++;
            $slug = $original_slug . "-" . $contatore;
            $apartments = Apartment::where("slug", $slug)->first();
        }
        //aggiungo lo slug all'array
        $data["slug"] = $slug;
        //aggiungo lo user id
        $data["user_id"] = Auth::user()->id;
        //rendo l'appartamento subito visibile
        $data["visibility"] = true;
        if (isset($data["cover_image"])) {
            $img_path = Storage::put('uploads', $data['cover_image']);
            $data["cover_image"] = $img_path;
        }
        //creiamo una nuoa istanza di appartamento
        $new_apartment = New Apartment();
        //compilo l'oggetto con la funzione fill
        $new_apartment->fill($data);
        //salvo il nuovo appartamento
        $new_apartment->save();
        //inserisco gli eventuali servizi nella tabella ponte
        if (!empty($data["services"])) {
            $new_apartment->services()->sync($data["services"]);
        };
        return redirect()->route("admin.apartments.index");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Apartment $apartment)
    {
        //definisco la data di scadenza con CARBON
        $current_timestamp = Carbon::now('Europe/Rome')->toDateTimeString();
        //recupero la sponsorizzazione in database più recente, dell'appartamento in oggetto
        $sponsorship = Sponsorship::all()->where("expiry_date", ">", $current_timestamp)->where("apartment_id","=", $apartment->id)->sortByDesc('created_at')->first();

        if ($apartment->user_id == Auth::user()->id) {
            $data = [
                "sponsorship" => $sponsorship,
                "apartment" => $apartment
            ];
            return view('admin.apartments.show', $data);
        } else {
            return abort('404');
        }


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Apartment $apartment)
    {

        if ($apartment->user_id != Auth::user()->id) {
          return abort('404');
        }

        $services = Service::all();
        $data = [
          'apartment' => $apartment,
          'services' => $services
        ];
        return view('admin.apartments.edit', $data);
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
      //valido i dati pervenuti lato-cliet
      $request->validate([
          "description_title" => "required|string|max:255",
          "cover_image" => "file|image|max:512",
          "description" => "nullable|min:50",
          "address" => "required|string",
          "lat" => ['required','regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'],
          "lon" => ['required','regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/'],
          "number_of_rooms" => "required|numeric|min:1|digits_between:1,11",
          "number_of_beds" => "required|numeric|min:1|digits_between:1,11",
          "number_of_bathrooms" => "required|numeric|min:1|digits_between:1,11",
          "square_meters" => "required|numeric|min:1|digits_between:1,11",
          "services" => "required"
      ]);
      //mappo i dati in un array
      $data= $request->all();
      //recupero l'appartamento con l'id della richiesta
      $apartment = Apartment::find($id);
      //geenro uno slug
      $slug = Str::of($data['description_title'])->slug('-');
      $original_slug = $slug;
      $apartments = Apartment::where("slug", $slug)->first();
      $contatore = 0;
      while ($apartments && $apartment->slug != $slug) {
          $contatore++;
          $slug = $original_slug . "-" . $contatore;
          $apartments = Apartment::where("slug", $slug)->first();
      }
      //aggiungo lo slug all'array
      $data["slug"] = $slug;
      //aggiungo lo user id
      $data["user_id"] = Auth::user()->id;
      if (isset($data['visibility'])) {
        $data['visibility'] = true;
      } else {
        $data['visibility'] = false;
      }
      if (isset($data["cover_image"])) {
          $img_path = Storage::put('uploads', $data['cover_image']);
          $data["cover_image"] = $img_path;
      };
      //salvo il nuovo appartamento
      $apartment->update($data);
      //inserisco gli eventuali servizi nella tabella ponte
      if (!empty($data["services"])) {
          $apartment->services()->sync($data["services"]);
      }else {
          $apartment->services()->detach();
      }
      return redirect()->route("admin.apartments.index");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $apartment = Apartment::find($id);
        if ($apartment) {
            $apartment->delete();
            return redirect()->route('admin.apartments.index');
        } else {
            return abort("404");
        }

    }
}
