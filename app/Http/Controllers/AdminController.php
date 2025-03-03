<?php

namespace App\Http\Controllers;

use App\Http\Requests\storeAdminRequest;
use App\Http\Requests\updateAdminRequest;
use Illuminate\Support\Facades\Log;  // Ajoute cette ligne en haut du fichier
use Illuminate\Support\Facades\Auth;

use App\Models\ResetCodePassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Notifications\SenEmailToAdminAfterRegistrationNotification;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Notification;

class AdminController extends Controller
{
    public function index(){

        $administrateurs = User::paginate(5);


        return view('administrateur.index',compact('administrateurs'));
    }
    public function create(){
        return view('administrateur.create');
    }
    public function edit (User $user){
        return view('administrateur.edit', compact('user'));
    }


    // Enrgistrer un admin en BD et envoyer un mail
    public function store(storeAdminRequest $request)
    {

        try{
            //logique de creation du compte de l'admin

            $user = new User ();

    $user ->name =$request->name;
    $user ->email =$request->email;

    $user ->password = Hash::make('default');
    $user->save();

  //Envoyer un amil pour que l'utlisateur confirme son compte

    if ($user){
        try{

    ResetCodePassword::where('email',$user->email )->delete();
    $code = rand(1000,4000);
    $data = [
        'code'=>$code,
        'email'=>$user->email,
    ];
    ResetCodePassword::create($data);
    $user->notify(new SenEmailToAdminAfterRegistrationNotification($code, $user->email));
    //Notification::route('mail',$user->email)->notify(new
    //SenEmailToAdminAfterRegistrationNotification($code,$user->email));
//Rediriger l'utilisateur vers une url
    return redirect()->route('administrateur.index')->with('success', 'administrateur ajouté avec succès.');



    } catch (Exception $e) {
        dd($e->getMessage()); // Affiche l'erreur exacte
    }

}

}catch(Exception $e){
   dd($e);
   // throw new Exception('Une erreur est survenue lors de la creation de cet admin');
}






    }
    public function update (updateAdminRequest $request, User $user){
        try{
            //la logique de mise a jour

return view ('administrateur.update',compact('user'));
        }catch(Exception $e){
           // dd($e);
            throw new Exception('Une erreur est survenue lors de la mise a jour  de cet admin');
        }
    }
    public function destroy($administrateurId)
    {
        try {
            // Récupération de l'administrateur connecté
            $connectedAdminId = Auth::id(); // Auth::id() est plus propre que Auth::user()->id

            // Récupération de l'administrateur à supprimer
            $administrateur = User::findOrFail($administrateurId);

            // Vérifier si l'admin essaie de se supprimer lui-même
            if ($connectedAdminId == $administrateur->id) {
                return redirect()->back()->with('error_message',
                    'Vous ne pouvez pas retirer votre propre compte');
            }

            // Suppression de l'administrateur
            $administrateur->delete();

            return redirect()->back()->with('success_message',
                'L\'administrateur a été retiré avec succès');

        } catch (\Exception $e) {
            // Gestion des erreurs (si l'administrateur n'existe pas, ou erreur DB)
            report($e);
            return redirect()->route('administrateur.index')->with('error',
                'Une erreur est survenue lors de la suppression.');
        }
    }

    public function defineAccess($email){

        $checkUserExist = User::where('email',$email)->first();

        if($checkUserExist){
    return view('auth.validate-account',compact('email'));
        }else{
            return redirect ()->route('login');
        }
    }
    public function submitDefineAccess(Request $request , $email){


$request->validate([

    'code' => 'required|exists:reset_code_passwords,code',
    'password' => 'required|same:confirm_password',
    'confirm_password' => 'required|same:password',
],
[
    'code.required'=>'le code est requis',
    'code.exists'=>'le code n\'est  pas valide consulter votre boite email',
    'password.same'=>'le mot de passe ne correspond pas',
    'confirm_password.same'=>'le mot de passe de confirmation ne correspond pas',

]);

   // Trouver l'utilisateur par email
   $user = User::where('email',$request->email)->first();

   if ($user) {
       // Mettre à jour le mot de passe
       $user->password = Hash::make($request->password);
       $user->email_verified_at = Carbon::now();
       $user->update();
// si la maj s'est fait correctement
       if ($user){

       $existingCode =  ResetCodePassword::where('email',$user->email)->count();
       if($existingCode >=1){
        ResetCodePassword::where('email',$user->email)->delete();
       }
       }

       return redirect()->route('login')->with('success-message', 'Votre mot de passe a été défini avec succès ! 🎉');
       dd(session()->all());
    }

   return back()->with('error', 'Utilisateur non trouvé.');
    }

}
