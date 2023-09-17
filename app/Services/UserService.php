<?php
namespace App\Services;

use Exception;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserService {
    
    protected $dataTableService;

    public function __construct(DataTableService $dataTableService)
    {
        $this->dataTableService = $dataTableService;
    }

    public function UserInDataTable()
    {
        try{
            //get the users data
            $users = User::getUsersData();
            //Return the data in datatable
            return $this->dataTableService->generateDataTable($users);
            
        }catch(Exception $e){
            Log::error('An error occured at: ' . $e->getMessage());
            return response()->json(['error' => 'Oops! Something went wrong']);
        }
    }

    //create the customer user
    public function createUser($request)
    {
        try {

            //Validate the request data
            $validator = Validator::make($request->all(), [
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8|confirmed'
            ]);
            
            //check if fails the validation return the errors in json into the signup form
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422); 
            }
            
            //if not fails  the credentials will be save to the database
            $user =   User::create([
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password'))
            ]);

            $user->assignRole('customer');
            
            $user->cart()->save(new Cart);
            //return a success message with sweat alert
            return response()->json(['message' => 'Account created successfuly!']);
            
        } catch (\Exception $e) {
            // Handle other exception
            $errors = Log::error('An error occured at: ' . $e->getMessage());
            return response()->json(['message' => $errors], 500);
        
        }
    }

    //edit the user
    public function editUser($user)
    {
        try{
            //check if user exist
            if(!$user){
                throw new NotFoundHttpException(); //throw a not found exceptions
            }
            return response()->json($user); //return the selected user
        }catch(Exception $e){
            Log::error('An error occured at: ' . $e->getMessage());
        }
    }

    //update the selected user
    public function updateUser($user, $validatedData)
    {
        try{
            //check if the user does not exist
            if(!$user){
                throw new NotFoundHttpException();
            }
            //update the user
            $user->first_name = $validatedData['first_name'];
            $user->last_name = $validatedData['last_name'];
            $user->email = $validatedData['email'];
            $user->password = Hash::make($validatedData['password']);
            $user->save();//save
            return response()->json(['message' => 'Successfuly updated'],201);
        }catch(Exception $e){
            Log::error('An error occured at: ' . $e->getMessage());
            return response()->json(['error' => 'Oops! Something went wrong'], 500);
        }
    }

    public function destroyUser($user)
    {
        try{
            if(!$user){
                throw new NotFoundHttpException();
            }
            $user->delete();
            return response()->json(['message' => 'Successfuly deleted!'],200);
        }catch(Exception $e){
            Log::error('An error occured at: ' . $e->getMessage());
            return response()->json(['error' => "Oops! Somethinbg went wrong"],500);
        }
    }

}