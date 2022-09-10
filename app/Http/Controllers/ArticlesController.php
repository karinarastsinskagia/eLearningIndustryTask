<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Hamcrest\Type\IsObject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Cast\Object_;
use SebastianBergmann\Type\ObjectType;
use App\Http\Requests\ArticlePostRequest;
use App\Http\Requests\ArticleUpdateRequest;
use Illuminate\Validation\ValidationException;
use App\Http\Resources\ArticleResource;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\ExternalServiceController;
use App\Http\Resources\ExternalServiceResource;


class ArticlesController extends Controller
{   

    public function __construct(Article $article)
    {
        $this->article = $article;
    }
    /**
     * Display all articles.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): JsonResponse
    {
        $articles = DB::table('articles')->get();
        return response()->json(['articles'=>$articles],200);
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ArticlePostRequest $request) : JsonResponse
    {   

        // $validated = $request->all();
       
        $this->article->title = $request['data']['attributes']['title'];
        $this->article->content = $request['data']['attributes']['content'];
        $this->article->category = isset($request['data']['attributes']['category']) ? $request['data']['attributes']['category'] : null;
        $this->article->save();
        $this->article->id;
       
        $article= DB::table('articles')->find($this->article->id);
        $externalServiceResource =  new ExternalServiceResource($article);
        $externalService = (new ExternalServiceController)->ExternalServiceCreateArticle($externalServiceResource);

        return response()->json(array('Success' => true, 'New article identifier' => $this->article->id), 200);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $article= DB::table('articles')->find($id);

        if(empty($article)){
            
            return response()->json('message=> The required article does not exist',403);
           
        }

        return new ArticleResource($article);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ArticleUpdateRequest $request, $id): ArticleResource
    {
        //$validated = $request->validated();
        
        $article = Article::find($id);
       
        if(empty($article)){
            
            echo "The article does not exist";
            exit;
        }
    

        $article->title = isset($request['data']['attributes']['title']) ? $request['data']['attributes']['title'] : $article->title;
        $article->content = isset($request['data']['attributes']['content']) ? $request['data']['attributes']['content'] : $article->content;
        $article->category =isset($request['data']['attributes']['category']) ? $request['data']['attributes']['category'] : $article->category;
        $input = $request->all();
        
        $updated = tap($article)->update($input)->where('id', $id)->first();
      
        $externalServiceResource =  new ExternalServiceResource($updated);
        $externalService = (new ExternalServiceController)->ExternalServiceEditArticle($externalServiceResource);

        return new ArticleResource($updated);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) : JsonResponse
    {
        $destroy = DB::table('articles')->where('id', $id)->delete();
        
        if($destroy){

            $externalService = (new ExternalServiceController)->ExternalServiceDeleteArticle($id);
            return response()->json('message=> The article deleted',200);
        }
        else{
            return response()->json('message=> Article does not exist',403);
        }
    }
}
