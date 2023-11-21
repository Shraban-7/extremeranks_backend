<?php

namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Startworking;
use App\Models\GeneralSetting;
use App\Models\Slider;
use App\Models\Roiseo;
use App\Models\Specialservice;
use App\Models\Whychoose;
use App\Models\Whychooseitem;
use App\Models\Businessgrow;
use App\Models\Success;
use App\Models\Testimonial;
use App\Models\Client;
use App\Models\Blogcategory;
use App\Models\Blog;
use App\Models\Analysis;
use App\Models\About;
use App\Models\Video;
use App\Models\Aboutcounter;
use App\Models\Aboutfaq;
use App\Models\Service;
use App\Models\Counter;
use App\Models\Researchwork;
use App\Models\Faq;
use App\Models\Category;
use App\Models\Package;
use App\Models\Attribute;
use App\Models\Pricing;
use App\Models\Createpage;
use App\Models\PageTitle;
use App\Models\SocialMedia;
use App\Models\Contact;
use App\Models\Country;
use App\Models\State;
use App\Models\Comment;
use App\Models\Sectiontitle;
use App\Models\Supportitem;
use App\Models\Transparent;
use App\Models\Needleitem;
use Mail;
use response;

class FrontEndController extends Controller
{
    
    public function easyway(){
        $easyway = Sectiontitle::where(['status'=>1, 'sectiontitlecat_id'=>1])->first();
        return response()->json(['status'=>"success", 'easyway'=>$easyway]); 
    }
    
    public function specialized(){
        $specialized = Sectiontitle::where(['status'=>1, 'sectiontitlecat_id'=>2])->first();
        return response()->json(['status'=>"success", 'specialized'=>$specialized]); 
    }
    
    public function testimonialtitle(){
        $testimonialtitle = Sectiontitle::where(['status'=>1, 'sectiontitlecat_id'=>3])->first();
        return response()->json(['status'=>"success", 'testimonialtitle'=>$testimonialtitle]); 
    }
    
    public function trustedpeople(){
        $trustedpeople = Sectiontitle::where(['status'=>1, 'sectiontitlecat_id'=>4])->first();
        return response()->json(['status'=>"success", 'trustedpeople'=>$trustedpeople]); 
    }
    
    public function blogtitle(){
        $blogtitle = Sectiontitle::where(['status'=>1, 'sectiontitlecat_id'=>5])->first();
        return response()->json(['status'=>"success", 'blogtitle'=>$blogtitle]); 
    }
    public function faqtitle(){
        $faqtitle = Sectiontitle::where(['status'=>1, 'sectiontitlecat_id'=>6])->first();
        return response()->json(['status'=>"success", 'faqtitle'=>$faqtitle]); 
    }
    
    public function keyresearchtitle(){
        $keyresearchtitle = Sectiontitle::where(['status'=>1, 'sectiontitlecat_id'=>7])->first();
        return response()->json(['status'=>"success", 'keyresearchtitle'=>$keyresearchtitle]); 
    }
    
    public function pricingtitle(){
        $pricingtitle = Sectiontitle::where(['status'=>1, 'sectiontitlecat_id'=>8])->first();
        return response()->json(['status'=>"success", 'pricingtitle'=>$pricingtitle]); 
    }
    
    public function freespace(){
        $freespace = Sectiontitle::where(['status'=>1, 'sectiontitlecat_id'=>9])->first();
        return response()->json(['status'=>"success", 'freespace'=>$freespace]); 
    }
    
    public function letsget(){
        $letsget = Sectiontitle::where(['status'=>1, 'sectiontitlecat_id'=>10])->first();
        return response()->json(['status'=>"success", 'letsget'=>$letsget]); 
    }
    
    public function niddletitle(){
        $niddletitle = Sectiontitle::where(['status'=>1, 'sectiontitlecat_id'=>11])->first();
        return response()->json(['status'=>"success", 'niddletitle'=>$niddletitle]); 
    }
    
    public function linkbuildingworktitle(){
        $linkbuildingworktitle = Sectiontitle::where(['status'=>1, 'sectiontitlecat_id'=>12])->first();
        return response()->json(['status'=>"success", 'linkbuildingworktitle'=>$linkbuildingworktitle]); 
    }
    
    public function linkinsertationworktitle(){
        $linkinsertationworktitle = Sectiontitle::where(['status'=>1, 'sectiontitlecat_id'=>13])->first();
        return response()->json(['status'=>"success", 'linkinsertationworktitle'=>$linkinsertationworktitle]); 
    }
    
    public function onpageseoranks(){
        $onpageseoranks = Sectiontitle::where(['status'=>1, 'sectiontitlecat_id'=>14])->first();
        return response()->json(['status'=>"success", 'onpageseoranks'=>$onpageseoranks]); 
    }
    public function managedseoranks(){
        $managedseoranks = Sectiontitle::where(['status'=>1, 'sectiontitlecat_id'=>15])->first();
        return response()->json(['status'=>"success", 'managedseoranks'=>$managedseoranks]); 
    }
    public function guestpostingtitle(){
        $guestpostingtitle = Sectiontitle::where(['status'=>1, 'sectiontitlecat_id'=>16])->first();
        return response()->json(['status'=>"success", 'guestpostingtitle'=>$guestpostingtitle]); 
    }
    
    public function articlewritingtitle(){
        $articlewritingtitle = Sectiontitle::where(['status'=>1, 'sectiontitlecat_id'=>17])->first();
        return response()->json(['status'=>"success", 'articlewritingtitle'=>$articlewritingtitle]); 
    }
    
    public function needletop(){
        $needletop = Needleitem::where(['status'=>1, 'type'=>1])->get();
        return response()->json(['status'=>"success", 'needletop'=>$needletop]); 
    }
    public function needlebottom(){
        $needlebottom = Needleitem::where(['status'=>1, 'type'=>2])->get();
        return response()->json(['status'=>"success", 'needlebottom'=>$needlebottom]); 
    }
    
    public function supportitem(){
        $supportitem = Supportitem::where(['status'=>1])->get();
        return response()->json(['status'=>"success", 'supportitem'=>$supportitem]); 
    }
    public function transparent(){
        $transparent = Transparent::where(['status'=>1])->get();
        return response()->json(['status'=>"success", 'transparent'=>$transparent]); 
    }
    
    
    
    public function servicefaqtitle(){
        $servicefaqtitle = Sectiontitle::where(['status'=>1, 'sectiontitlecat_id'=>18])->first();
        return response()->json(['status'=>"success", 'servicefaqtitle'=>$servicefaqtitle]); 
    }
    
    public function transparenttitle(){
        $transparenttitle = Sectiontitle::where(['status'=>1, 'sectiontitlecat_id'=>19])->first();
        return response()->json(['status'=>"success", 'transparenttitle'=>$transparenttitle]); 
    }
    
    
    
    public function keywordresearch(){
        $category = Category::where('status',1)->first();
        return response()->json(['status'=>"success", 'category'=>$category]);
    }
    
    public function linkbuilding(){
        $category = Category::where('status',1)->first();
        return response()->json(['status'=>"success", 'category'=>$category]);
    }
    
    public function linkinsertation(){
        $category = Category::where('status',1)->first();
        return response()->json(['status'=>"success", 'category'=>$category]);
    }
    
    public function onpageseo(){
        $category = Category::where('status',1)->first();
        return response()->json(['status'=>"success", 'category'=>$category]);
    } 
    
    public function managedseo(){
        $category = Category::where('status',1)->first();
        return response()->json(['status'=>"success", 'category'=>$category]);
    }
    
    public function guestposting(){
        $category = Category::where('status',1)->first();
        return response()->json(['status'=>"success", 'category'=>$category]);
    }
    public function articlewriting(){
        $category = Category::where('status',1)->first();
        return response()->json(['status'=>"success", 'category'=>$category]);
    }
    
    public function generalsetting(){
        $generalsettings = GeneralSetting::where('status',1)->first();
        return response()->json(['status'=>"success", 'generalsettings'=>$generalsettings]);
    }
    public function contactinfo(){
        $contactinfo = Contact::where('status',1)->limit(1)->get();
        $contactmeta = Contact::where('status',1)->first();
        
        return response()->json(['status'=>"success", 'contactinfo'=>$contactinfo,'contactmeta'=>$contactmeta]);
    }
    public function categories(){
        $categories = Category::where('status',1)->get();
        return response()->json(['status'=>"success", 'categories'=>$categories]);
    }
    
    public function footercategories(){
        $footercategories = Category::where('status',1)->limit(5)->get();
        return response()->json(['status'=>"success", 'footercategories'=>$footercategories]);
    }
    public function footercategoriesone(){
        $footercategoriesone = Category::where('status',1)->skip(5)->limit(10)->get();
        return response()->json(['status'=>"success", 'footercategoriesone'=>$footercategoriesone]);
    }
    
    public function slider(){
        $sliders = Slider::where('status',1)->limit(1)->get();
        return response()->json(['status'=>"success", 'sliders'=>$sliders]);
    }

    public function startworking(){
        $startworkings = Startworking::where('status',1)->get();
        return response()->json(['status'=>"success", 'startworkings'=>$startworkings]);
    }
    public function roiseo(){
        $roiseo = Roiseo::where('status',1)->limit(1)->get();
        return response()->json(['status'=>"success", 'roiseo'=>$roiseo]);
    }

    public function specialservice(){
        $specialservices = Specialservice::where('status',1)->limit(6)->get();
        return response()->json(['status'=>"success", 'specialservices'=>$specialservices]);
    }

    public function whychoose(){
        $whychoose = Whychoose::where('status',1)->limit(1)->get();
        return response()->json(['status'=>"success", 'whychoose'=>$whychoose]);
    }

    public function whychooseitem(){
        $whychooseitem = Whychooseitem::where('status',1)->limit(3)->get();
        return response()->json(['status'=>"success", 'whychooseitem'=>$whychooseitem]);
    }

    public function businessgrow(){
        $businessgrow = Businessgrow::where('status',1)->limit(1)->get();
        return response()->json(['status'=>"success", 'businessgrow'=>$businessgrow]);
    }

    public function success(){
        $success = Success::where('status',1)->limit(3)->get();
        return response()->json(['status'=>"success", 'success'=>$success]);
    }
    public function testimonial(){
        $testimonials = Testimonial::where('status',1)->get();
        return response()->json(['status'=>"success", 'testimonials'=>$testimonials]);
    }

    public function clints(){
        $clints = Client::where('status',1)->get();
        return response()->json(['status'=>"success", 'clints'=>$clints]);
    }

    public function homeblogs(){
        $homeblogs = Blog::where('status',1)->limit(3)->orderBy('id','DESC')->get();
        return response()->json(['status'=>"success", 'homeblogs'=>$homeblogs]);
    }

    public function blogs(Request $request){
        $bcategories = Blogcategory::where('status',1)->get();
        $recentblogs = Blog::where('status',1)->latest()->limit(4)->orderBy('id','DESC')->get();
        
        if($request->keyword != 'undefined' || $request->keyword == null){
            $blogs = Blog::where('status',1)->where('title', 'LIKE', '%' . $request->keyword . "%")->limit(4)->withCount('comments')->orderBy('id','DESC')->get();
        }else{
            $blogs = Blog::where('status',1)->limit(4)->withCount('comments')->orderBy('id','DESC')->get();
        }
        $bredcrumb = PageTitle::where(['status'=>1,'pagename'=>'our-blog'])->orderBy('id','DESC')->first();
        return response()->json(['status'=>"success", 'blogs'=>$blogs,'bcategories'=>$bcategories,'recentblogs'=>$recentblogs,'bredcrumb'=>$bredcrumb]);
    }
    public function blogcategory($slug, Request $request){
        $blogcategory = Blogcategory::where(['slug'=>$slug])->first();
        $bcategories = Blogcategory::where('status',1)->get();
        $recentblogs = Blog::where('status',1)->latest()->limit(4)->orderBy('id','DESC')->get();
        if($request->keyword != 'undefined' || $request->keyword == null){
            $blogs = Blog::where(['status'=>1,'category_id'=>$blogcategory->id])->where('title', 'LIKE', '%' . $request->keyword . "%")->limit(4)->withCount('comments')->orderBy('id','DESC')->get();
        }else{
            $blogs = Blog::where(['status'=>1,'category_id'=>$blogcategory->id])->limit(4)->withCount('comments')->orderBy('id','DESC')->get();
        }
        
        
        $bredcrumb = PageTitle::where(['status'=>1,'pagename'=>'our-blog'])->orderBy('id','DESC')->first();
        return response()->json(['status'=>"success", 'blogs'=>$blogs,'bcategories'=>$bcategories,'recentblogs'=>$recentblogs,'blogcategory'=>$blogcategory,'bredcrumb'=>$bredcrumb]);
    }
    public function blogdetails($slug, Request $reqeust){
        $bcategories = Blogcategory::where('status',1)->get();
        $recentblogs = Blog::where('status',1)->latest()->limit(4)->orderBy('id','DESC')->get();
        $details = Blog::where(['slug'=>$slug,'status'=>1])->withCount('comments')->firstOrfail();
        
        $comments = Comment::where(['status'=>1,'blog_id'=>$details->id])->latest()->limit(10)->with('customer')->get();
        $latestcomment = Comment::where(['status'=>1,'blog_id'=>$details->id])->latest()->limit(1)->with('customer')->get();
        $bredcrumb = PageTitle::where(['status'=>1,'pagename'=>'our-blog'])->orderBy('id','DESC')->first();
        return response()->json(['status'=>"success", 'details'=>$details,'bcategories'=>$bcategories,'recentblogs'=>$recentblogs,'comments'=>$comments,'latestcomment'=>$latestcomment,'bredcrumb'=>$bredcrumb]);
    }

    public function analysis(){
        $analysis = Analysis::where('status',1)->limit(1)->orderBy('id','DESC')->get();
        return response()->json(['status'=>"success", 'analysis'=>$analysis]);
    }

    public function about(){
        $specialservices = Specialservice::where('status',1)->limit(3)->get();
        $about = About::where('status',1)->limit(1)->orderBy('id','DESC')->first();
        $bredcrumb = PageTitle::where(['status'=>1,'pagename'=>'about'])->orderBy('id','DESC')->first();
        return response()->json(['status'=>"success", 'about'=>$about, 'specialservices'=>$specialservices,'bredcrumb'=>$bredcrumb]);
    }

    public function video(){
        $video = Video::where('status',1)->limit(1)->orderBy('id','DESC')->get();
        return response()->json(['status'=>"success", 'video'=>$video]);
    }

    public function aboutcounter(){
        $aboutcounter = Aboutcounter::where('status',1)->orderBy('id','ASC')->get();
        return response()->json(['status'=>"success", 'aboutcounter'=>$aboutcounter]);
    }

    public function aboutfaq(){
        $aboutfaq = Aboutfaq::where('status',1)->orderBy('id','ASC')->get();
        return response()->json(['status'=>"success", 'aboutfaq'=>$aboutfaq]);
    }

    // Keyword Research 
    public function keywservicetop(){
        $keywservicetop = Service::where(['status'=>1, 'category_id'=>1])->limit(2)->orderBy('id','ASC')->get();
        return response()->json(['status'=>"success", 'keywservicetop'=>$keywservicetop]);
    }

    public function keywservicebottom(){
        $keywservicebottom = Service::where(['status'=>1, 'category_id'=>1])->skip(2)->limit(4)->orderBy('id','ASC')->get();
        return response()->json(['status'=>"success", 'keywservicebottom'=>$keywservicebottom]);
    }
    public function keywservicecounter(){
        $keywservicecounter = Counter::where(['status'=>1, 'category_id'=>1])->limit(3)->orderBy('id','ASC')->get();
        return response()->json(['status'=>"success", 'keywservicecounter'=>$keywservicecounter]);
    }

    public function keywservicework(){
        $keywservicework = Researchwork::where(['status'=>1, 'category_id'=>1])->limit(3)->orderBy('id','ASC')->get();
        $bredcrumb = PageTitle::where(['status'=>1,'pagename'=>'keyword-research'])->orderBy('id','DESC')->first();
        return response()->json(['status'=>"success", 'keywservicework'=>$keywservicework, 'bredcrumb'=>$bredcrumb]);
    }

    public function keywservicefaq(){
        $keywservicefaq = Faq::where(['status'=>1, 'category_id'=>1])->orderBy('id','ASC')->get();
        return response()->json(['status'=>"success", 'keywservicefaq'=>$keywservicefaq]);
    }

    // Link Building 
    public function linkbuildingtop(){
        $linkbuildingtop = Service::where(['status'=>1, 'category_id'=>2])->limit(2)->orderBy('id','ASC')->get();
        return response()->json(['status'=>"success", 'linkbuildingtop'=>$linkbuildingtop]);
    }

    public function linkbuildingbottom(){
        $linkbuildingbottom = Service::where(['status'=>1, 'category_id'=>2])->skip(2)->limit(4)->orderBy('id','ASC')->get();
        return response()->json(['status'=>"success", 'linkbuildingbottom'=>$linkbuildingbottom]);
    }
    public function linkbuildingcounter(){
        $linkbuildingcounter = Counter::where(['status'=>1, 'category_id'=>2])->limit(3)->orderBy('id','ASC')->get();
        return response()->json(['status'=>"success", 'linkbuildingcounter'=>$linkbuildingcounter]);
    }

    public function linkbuildingwork(){
        $linkbuildingwork = Researchwork::where(['status'=>1, 'category_id'=>2])->limit(3)->orderBy('id','ASC')->get();
        $bredcrumb = PageTitle::where(['status'=>1,'pagename'=>'link-building'])->orderBy('id','DESC')->first();
        return response()->json(['status'=>"success", 'linkbuildingwork'=>$linkbuildingwork, 'bredcrumb'=>$bredcrumb]);
    }

    public function linkbuildingfaq(){
        $linkbuildingfaq = Faq::where(['status'=>1, 'category_id'=>2])->orderBy('id','ASC')->get();
        return response()->json(['status'=>"success", 'linkbuildingfaq'=>$linkbuildingfaq]);
    }

    // Link Insertation 
    public function linkinsertationtop(){
        $linkinsertationtop = Service::where(['status'=>1, 'category_id'=>3])->limit(2)->orderBy('id','ASC')->get();
        return response()->json(['status'=>"success", 'linkinsertationtop'=>$linkinsertationtop]);
    }

    public function linkinsertationbottom(){
        $linkinsertationbottom = Service::where(['status'=>1, 'category_id'=>3])->skip(2)->limit(4)->orderBy('id','ASC')->get();
        return response()->json(['status'=>"success", 'linkinsertationbottom'=>$linkinsertationbottom]);
    }
    public function linkinsertationcounter(){
        $linkinsertationcounter = Counter::where(['status'=>1, 'category_id'=>3])->limit(3)->orderBy('id','ASC')->get();
        return response()->json(['status'=>"success", 'linkinsertationcounter'=>$linkinsertationcounter]);
    }

    public function linkinsertationwork(){
        $linkinsertationwork = Researchwork::where(['status'=>1, 'category_id'=>3])->limit(3)->orderBy('id','ASC')->get();
        $bredcrumb = PageTitle::where(['status'=>1,'pagename'=>'link-insertation'])->orderBy('id','DESC')->first();
        return response()->json(['status'=>"success", 'linkinsertationwork'=>$linkinsertationwork, 'bredcrumb'=>$bredcrumb]);
    }

    public function linkinsertationfaq(){
        $linkinsertationfaq = Faq::where(['status'=>1, 'category_id'=>3])->orderBy('id','ASC')->get();
        return response()->json(['status'=>"success", 'linkinsertationfaq'=>$linkinsertationfaq]);
    }


    // On page Seo
    public function onpageseotop(){
        $onpageseotop = Service::where(['status'=>1, 'category_id'=>4])->limit(2)->orderBy('id','ASC')->get();
        return response()->json(['status'=>"success", 'onpageseotop'=>$onpageseotop]);
    }

    public function onpageseobottom(){
        $onpageseobottom = Service::where(['status'=>1, 'category_id'=>4])->skip(2)->limit(4)->orderBy('id','ASC')->get();
        return response()->json(['status'=>"success", 'onpageseobottom'=>$onpageseobottom]);
    }
    public function onpageseocounter(){
        $onpageseocounter = Counter::where(['status'=>1, 'category_id'=>4])->limit(3)->orderBy('id','ASC')->get();
        return response()->json(['status'=>"success", 'onpageseocounter'=>$onpageseocounter]);
    }

    public function onpageseowork(){
        $onpageseowork = Researchwork::where(['status'=>1, 'category_id'=>4])->limit(6)->orderBy('id','ASC')->get();
        $bredcrumb = PageTitle::where(['status'=>1,'pagename'=>'on-page-seo'])->orderBy('id','DESC')->first();
        return response()->json(['status'=>"success", 'onpageseowork'=>$onpageseowork, 'bredcrumb'=>$bredcrumb]);
    }

    public function onpageseofaq(){
        $onpageseofaq = Faq::where(['status'=>1, 'category_id'=>4])->orderBy('id','ASC')->get();
        return response()->json(['status'=>"success", 'onpageseofaq'=>$onpageseofaq]);
    }

    // Managed Seo
    public function managedseotop(){
        $managedseotop = Service::where(['status'=>1, 'category_id'=>5])->limit(2)->orderBy('id','ASC')->get();
        return response()->json(['status'=>"success", 'managedseotop'=>$managedseotop]);
    }
    

    public function managedseobottom(){
        $managedseobottom = Service::where(['status'=>1, 'category_id'=>5])->skip(2)->limit(4)->orderBy('id','ASC')->get();
        return response()->json(['status'=>"success", 'managedseobottom'=>$managedseobottom]);
    }
    public function managedseocounter(){
        $managedseocounter = Counter::where(['status'=>1, 'category_id'=>5])->limit(3)->orderBy('id','ASC')->get();
        return response()->json(['status'=>"success", 'managedseocounter'=>$managedseocounter]);
    }

    public function managedseowork(){
        $managedseowork = Researchwork::where(['status'=>1, 'category_id'=>5])->limit(6)->orderBy('id','ASC')->get();
        $bredcrumb = PageTitle::where(['status'=>1,'pagename'=>'managed-seo'])->orderBy('id','DESC')->first();
        return response()->json(['status'=>"success", 'managedseowork'=>$managedseowork, 'bredcrumb'=>$bredcrumb]);
    }

    public function managedseofaq(){
        $managedseofaq = Faq::where(['status'=>1, 'category_id'=>5])->orderBy('id','ASC')->get();
        return response()->json(['status'=>"success", 'managedseofaq'=>$managedseofaq]);
    }

    // Guest Posting
    public function guestpostingtop(){
        $guestpostingtop = Service::where(['status'=>1, 'category_id'=>6])->limit(2)->orderBy('id','ASC')->get();
        return response()->json(['status'=>"success", 'guestpostingtop'=>$guestpostingtop]);
    }

    public function guestpostingbottom(){
        $guestpostingbottom = Service::where(['status'=>1, 'category_id'=>6])->skip(2)->limit(4)->orderBy('id','ASC')->get();
        return response()->json(['status'=>"success", 'guestpostingbottom'=>$guestpostingbottom]);
    }
    public function guestpostingcounter(){
        $guestpostingcounter = Counter::where(['status'=>1, 'category_id'=>6])->limit(3)->orderBy('id','ASC')->get();
        return response()->json(['status'=>"success", 'guestpostingcounter'=>$guestpostingcounter]);
    }

    public function guestpostingwork(){
        $guestpostingwork = Researchwork::where(['status'=>1, 'category_id'=>6])->limit(6)->orderBy('id','ASC')->get();
        $bredcrumb = PageTitle::where(['status'=>1,'pagename'=>'guest-posting'])->orderBy('id','DESC')->first();
        return response()->json(['status'=>"success", 'guestpostingwork'=>$guestpostingwork, 'bredcrumb'=>$bredcrumb]);
    }

    public function guestpostingfaq(){
        $guestpostingfaq = Faq::where(['status'=>1, 'category_id'=>6])->orderBy('id','ASC')->get();
        return response()->json(['status'=>"success", 'guestpostingfaq'=>$guestpostingfaq]);
    }

    // Article Writing
    public function articlewritingtop(){
        $articlewritingtop = Service::where(['status'=>1, 'category_id'=>7])->limit(1)->orderBy('id','ASC')->get();

        return response()->json(['status'=>"success", 'articlewritingtop'=>$articlewritingtop]);
    }

    public function articlewritingbottom(){
        $articlewritingbottom = Service::where(['status'=>1, 'category_id'=>7])->skip(1)->limit(4)->orderBy('id','ASC')->get();
        return response()->json(['status'=>"success", 'articlewritingbottom'=>$articlewritingbottom]);
    }
    public function articlewritingcounter(){
        $articlewritingcounter = Counter::where(['status'=>1, 'category_id'=>7])->limit(4)->orderBy('id','ASC')->get();
        return response()->json(['status'=>"success", 'articlewritingcounter'=>$articlewritingcounter]);
    }

    public function articlewritingwork(){
        $articlewritingwork = Researchwork::where(['status'=>1, 'category_id'=>7])->limit(6)->orderBy('id','ASC')->get();
        $bredcrumb = PageTitle::where(['status'=>1,'pagename'=>'article-writing'])->orderBy('id','DESC')->first();
        return response()->json(['status'=>"success", 'articlewritingwork'=>$articlewritingwork, 'bredcrumb'=>$bredcrumb]);
    }

    public function articlewritingfaq(){
        $articlewritingfaq = Faq::where(['status'=>1, 'category_id'=>7])->orderBy('id','ASC')->get();
        return response()->json(['status'=>"success", 'articlewritingfaq'=>$articlewritingfaq]);
    }

     public function pricing($slug){
        $category = Category::where(['slug'=>$slug])->first();
        $packages = Package::where(['category_id'=>$category->id,'status'=>1,'type'=>1])->with('category')->get();
        $attributes = Attribute::where(['category_id'=>$category->id,'status'=>1])->with('pricing')->get();
        $bredcrumb = PageTitle::where(['status'=>1,'pagename'=>$slug])->orderBy('id','DESC')->first();
        return response()->json(['status'=>"success", 'category'=>$category,'packages'=>$packages,'attributes'=>$attributes,'bredcrumb'=>$bredcrumb]);
    }

    
    public function pagename(){
        $pagename = Createpage::where('status',1)->select('id','slug','pagename')->get();
        return response()->json(['status'=>"success", 'pagename'=>$pagename]);
    }
    public function morepage($slug){
        $pages = Createpage::where(['status'=>1, 'slug'=>$slug])->first();
        $bredcrumb = PageTitle::where(['status'=>1,'pagename'=>$slug])->orderBy('id','DESC')->first();
        return response()->json(['status'=>"success",'pages'=>$pages,'bredcrumb'=>$bredcrumb]);
    }

    public function socialmedia(){
      $socialmedia = SocialMedia::where('status',1)->get();
        return response()->json(['status'=>"success", 'socialmedia'=>$socialmedia]);  
    }
    
    public function countries(){
        $countries = Country::get();
        return response()->json(compact('countries'), 200);
    }
   
    public function states($country_id){
        $states = State::where('country_id',$country_id)->get();
        return response()->json(compact('states'), 200);
    }
    public function areas($district_id)
    {
        $areas = Area::where(['status' => 1, 'district_id' => $district_id])->get();
        return response()->json(compact('areas'), 200);
    }
    
    public function seo_checker(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'website' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'=>'validationfail',
                'errors'=>'validation_error',
                'message'=>$validator->errors()
            ]);
        }
        
           $data = array(
                 'name'        => $request->name,
                 'email'       => $request->email,
                 'phone'       => $request->phone,
                 'website'     => $request->website
                );
            $send = Mail::send('frontEnd.emails.seochecker', $data, function($textmsg) use ($data){
              $textmsg->to('info@extremeranks.com');
              $textmsg->subject($data['name'].' Send query for SEO Checker');
            });
            

        return response()->json(['status' => 'success']);
    }
    
    
    public function subscribe(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'=>'validationfail',
                'errors'=>'validation_error',
                'message'=>$validator->errors()
            ]);
        }
        
           $data = array(
                 'email'       => $request->email,
                );
           
            
            $send = Mail::send('frontEnd.emails.subscribe', $data, function($textmsg) use ($data){
              $textmsg->to('info@extremeranks.com');
              $textmsg->subject('Subscribe Email');
            });
            

        return response()->json(['status' => 'success']);
        
    }
    
    
    
    
    



}
