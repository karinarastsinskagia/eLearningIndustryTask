<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Article;
use App\Http\Requests\CommentPostRequest;
use App\Http\Requests\CommentUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\CommentResource;

class CommentsController extends Controller
{   

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }
    /**
     * Display the comments of an article.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($article_id) : JsonResponse
    {
        $id= $article_id;
        $article = Article::find($id);

        if(empty($article)){
            
            echo "The article does not exist";
            exit;
        }
        $articlesComments = [];
        

        foreach ($article->comments as $comment) {
            
            $newCommentObject = new CommentResource($comment);
            array_push($articlesComments, $newCommentObject);
        }

        //print_r($artcile->comments);
        return response()->json(array('Success' => true, 'Article'=> new ArticleResource($article), 'Comments' => $articlesComments), 200);
    }
    

    /**
     * Store a newly created resource in storage.
     *
     * 
     * @return \Illuminate\Http\Response
     */
    public function store($article_id,CommentPostRequest $request) :JsonResponse
    {   
        $id= $article_id;
        $artcile = Article::find($id);

        if(empty($artcile)){
            
            echo "The article does not exist";
            exit;
        }
        $this->comment->owner = $request['data']['attributes']['owner'];
        $this->comment->content = $request['data']['attributes']['content'];
        $this->comment->article_id = $article_id;

       
        $this->comment->save();
        $this->comment->id;

        return response()->json(array('Success' => true, 'New comment identifier' => $this->comment->id), 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) : CommentResource
    {
        $comment= DB::table('comments')->find($id);

        if(empty($comment)){
            
            echo "The required comment does not exist";
            exit;
           
        }

        return new CommentResource($comment);
    }


    /**
     * Update the specified resource in storage.
     *
     * 
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CommentUpdateRequest $request, $id) : CommentResource
    {
        $comment = Comment::find($id);

        if(empty($comment)){
            
            echo "The comment does not exist";
            exit;
        }
    

        $comment->content = $request['data']['attributes']['content'] ;
        $input = $request->all();
        
        $updated = tap($comment)->update($input)->where('id', $id)->first();
      
       
        return new CommentResource($updated);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) : JsonResponse
    {
        $destroy = DB::table('comments')->where('id', $id)->delete();
        
        if($destroy){
            return response()->json('message=> The comment deleted',200);
        }
        else{
            return response()->json('message=> Comment does not exist',403);
        }
    }
}
