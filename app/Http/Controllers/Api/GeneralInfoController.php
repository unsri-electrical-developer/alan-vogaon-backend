<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\Contact;
use App\Models\SocialContact;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class GeneralInfoController extends ApiController
{

    public function getGeneralInfo()
    {
        $about = About::first(['body', 'meta_title', 'meta_desc', 'meta_keyword']);

        $contact = Contact::all(['contact_code', 'contact_name', 'contact_url']);
        // $contact_arr = [];
        // foreach ($contact as $item) {
        //     $contact_arr[$item->contact_code] = $item->contact_url;
        // }

        $social_media = SocialContact::all(['social_contact_code', 'social_contact_name', 'social_contact_url']);
        // $social_media_arr = [];
        // foreach ($social_media as $social) {
        //     $social_media_arr[$social->social_contact_code] = $social->social_contact_url;
        // }

        $general_info = collect([
            'about' => $about,
            'contact' => $contact,
            'social_contact' => $social_media
        ]);

        return $this->sendResponse(0, "Sukses", $general_info);
    }

    public function setGeneralInfo(Request $request)
    {
        if ($request->has('about')) {
            About::updateOrCreate(
                ['about_code' => 'about'],
                ['body' => $request->about['body'], 'meta_title' => $request->about['meta_title'], 'meta_desc' => $request->about['meta_desc'], 'meta_keyword' => $request->about['meta_keyword']],
            );
        }

        if ($request->has('contact')) {
            foreach ($request->contact as $item) {
                Contact::where('contact_code', $item['contact_code'])
                    ->update(['contact_url' => $item['contact_url']]);
            }
        }

        if ($request->has('social_contact')) {
            foreach ($request->social_contact as $item_sc) {
                SocialContact::where('social_contact_code', $item_sc['social_contact_code'])
                    ->update(['social_contact_url' => $item_sc['social_contact_url']]);
            }
        }

        return $this->sendResponse(0, "Data berhasil disimpan!", $request->all());
    }
}
