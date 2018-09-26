<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Member;
use App\Http\Requests\StoreMemberRequest;
use App\Http\Requests\UpdateMemberRequest;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $members = new Member;
        $result = $members->showAllMembers();
        $content = view('member.items',['result' => $result])->render();

        return response()->json(['html' => $content]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $content = view('member.create')->render();

        return response()->json(['html' => $content]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMemberRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMemberRequest $request)
    {
        $member = new Member;
        $member->storeMember($request);

        return response()->json($member);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $members = new Member;
        $result = $members->showMember($id);
        $content = view('member.detail',['result' => $result])->render();

        return response()->json(['html' => $content]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $members = new Member;
        $result = $members->showMember($id);
        $content = view('member.edit',['result' => $result])->render();

        return response()->json(['html' => $content]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMemberRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMemberRequest $request, $id)
    {
        $member = new Member;
        $result = $member->updateMember($request, $id);
        $content = view('member.update',['result' => $result])->render();

        return response()->json(['html' => $content]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $member = new Member;
        return $member->deleteMember($id);
    }
}
