<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use App\Services\SiteService;
use App\Services\SubjectService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    public function findTutors(Request $request)
    {
        $service  = new SubjectService(Auth::user());
        $subjectGroups = $service->getSubjectGroups();
        $subjects = $service->getSubjects();
        $helpContent = setting('_tutor');
        $countries = [];
        $languages = (new SiteService)->getLanguages();
        if(empty(setting('_api.google_places_api_key'))){
            $countries = (new SiteService)->getCountries();

        }
        $filters = array();
        $filters['session_type'] = $request->get('session_type') ?? '';
        $filters['keyword']      = $request->get('keyword') ?? null;
        $filters['group_id']     = $request->get('group_id') ?? null;
        $filters['subject_id']   = array_filter(explode(',', $request->get('subject_id')), fn($value, $key) => $key !== 0 || $value !== '', ARRAY_FILTER_USE_BOTH);
        $filters['language_id']  = array_filter(explode(',', $request->get('language_id')), fn($value, $key) => $key !== 0 || $value !== '', ARRAY_FILTER_USE_BOTH);
        $filters['max_price']    = $request->get('max_price') ?? null;
        $filters['country']      = $request->get('country') ?? null;
        $filters['sort_by']      = $request->get('sort_by') ?? null;

        return view('frontend.find-tutors', compact('subjectGroups','subjects', 'helpContent', 'countries', 'languages', 'filters'));
    }

    public function tutorDetail(Request $request,$slug)
    {
        $siteService  = new SiteService();
        $tutor = $siteService->getTutorDetail($slug);
        if(empty($tutor)){
            abort('404');
        }
        $totalSlots = $tutor->subjects->flatMap(function ($subject) {
            return $subject->slots;
        })->count();
        $user = Auth::user();
        $userService = new UserService($user);
        $isFavourite = $userService->isFavouriteUser($tutor?->id ?? 0);
        $isAdmin = auth()?->user() && auth()?->user()?->hasRole('admin') ?? true;
        if($tutor?->profile?->verified_at || $isAdmin){
            $reviews       = Rating::where('tutor_id',$tutor->id)->count();
            return view('frontend.tutor-detail', compact('tutor','reviews', 'isFavourite','totalSlots'));
        }
        abort('404');
    }
        
    public function favouriteTutor(Request $request)
    {
        $userId = $request?->userId ?? '';
        if ( Auth::user()?->role == 'student'){
            $userService = new UserService(Auth::user());
            $isFavourite = $userService->isFavouriteUser($userId);
            if($isFavourite){
                $userService->removeFromFavourite($userId);
            } else {
                $userService->addToFavourite($userId);
            }
            return response()->json(['type' => 'success']);
        }
    }
}
