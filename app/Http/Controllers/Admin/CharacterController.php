<?php

namespace App\Http\Controllers\Admin;

use App\Character;
use App\DataTables\CharactersDataTable;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Validation\Rule;

class CharacterController extends Controller
{
    public function index(CharactersDataTable $dataTable)
    {
        return $dataTable->render('characters.index');
    }

    public function show(Character $character)
    {
        ddd($character);
    }

    public function edit(Character $character = null)
    {
        if (isset($character))
        {
            $character->load(['user.account']);
        }

        return view('characters.edit', [
            'character' => $character ?? '',
        ]);
    }

    /*
        // UPDATE _Char set CharName16 = @NewName where CharID = @CharID
        // update _Friend set friendcharname = @NewName where friendcharid = @CharID
        // update _GuildMember set charname = @NewName where charid = @CharID
        // update _Memo set fromcharname = @NewName where fromcharname = @old_name
        // update _TrainingCampMember set charname = @NewName where charid = @CharID
        // insert _CharNameList values(@NewName, @CharID)
        // update _Items set CreaterName = @NewName
        // _GPHistory
        // _BlockedWhisperers
    */
    public function updateName(Character $character)
    {
        request()->validate([
            'CharName16' => ['required', 'string', Rule::unique('shard._CharNameList', 'CharName16')->ignore($character->CharName16, 'CharName16')],
            'NickName16' => ['required', 'nullable', 'alpha_num', Rule::unique('shard._CharNickNameList', 'NickName16')->ignore($character->NickName16, 'NickName16')],
            'force_name_change' => ['sometimes', 'boolean'],
        ]);

        if (!request('force_name_change'))
        {
            request()->validate([
                'CharName16' => ['alpha_num'],
            ]);
        }

        if ($character->CharName16 != request('CharName16'))
        {
            if (request('force_name_change'))
            {
                $character->update([
                    'CharName16' => "@{$character->CharName16}",
                ]);
            }
            else
            {
                $character->shardcharname()->update([
                    'CharName' => request('CharName16'),
                ]);

                $character->charname()->create([
                    'CharName16' => request('CharName16'),
                ]);

                if ($character->guildmember()->exists())
                {
                    $character->guildmember()->update([
                        'CharName' => request('CharName16'),
                    ]);
                }

                if ($character->academyMember()->exists())
                {
                    $character->academyMember()->update([
                        'CharName' => request('CharName16'),
                    ]);
                }

                if ($character->createdItems()->exists())
                {
                    $character->createdItems()->update([
                        'CreaterName' => request('CharName16'),
                    ]);
                }

                // _BlockedWhisperers
                DB::connection('shard')->table('_BlockedWhisperers')->where('TargetName', $character->CharName16)->update([
                    'TargetName' => request('CharName16'),
                ]);

                // _Friend
                DB::connection('shard')->table('_Friend')->where('FriendCharID', $character->CharID)->update([
                    'FriendCharName' => request('CharName16'),
                ]);

                // _GPHistory
                DB::connection('shard')->table('_GPHistory')->where('CharName', $character->CharName16)->update([
                    'CharName' => request('CharName16'),
                ]);

                // _Memo
                DB::connection('shard')->table('_Memo')->where('FromCharName', $character->CharName16)->update([
                    'FromCharName' => request('CharName16'),
                ]);

                $character->update([
                    'CharName16' => request('CharName16'),
                ]);
            }
        }

        if ($character->NickName16 != request('NickName16') && request()->filled('NickName16'))
        {
            $character->charnickname()->create([
                'NickName16' => request('NickName16'),
            ]);

            $character->update([
                'NickName16' => request('NickName16'),
            ]);
        }

        return response()->json([
            'title' => 'Success!',
            'message' => 'Updated!',
            'icon' => 'success',
        ]);
    }

    public function getPosition()
    {
        request()->validate([
            'character' => ['required', 'string', 'exists:App\Character,CharName16'],
        ]);

        $character = Character::firstWhere('CharName16', request('character'));

        return response()->json([
            'characterid' => $character->CharID,
            'RegionId' => $character->LatestRegion,
            'PosX' => $character->PosX,
            'PosY' => $character->PosY,
            'PosZ' => $character->PosZ,
            'WorldId' => $character->WorldID,
            'title' => 'Updated!',
            'message' => 'Character position is successfully retrieved.',
            'icon' => 'success',
        ]);
    }

    public function getInfo(Character $character)
    {
        if (!request()->expectsJson())
        {
            abort(404);
        }

        $character->load(['user.account']);

        return response()->json([
            'character' => $character,
        ]);
    }

    public function getCharNames()
    {
        if (!request()->expectsJson())
        {
            return;
        }

        $search = request()->validate([
            'search' => ['string'],
        ])['search'];

        $paginator = Character::select(['CharID', 'CharName16', 'NickName16', 'CurLevel'])->where('CharName16', 'like', "{$search}%")->orWhere('NickName16', 'like', "{$search}%")->paginate(10);

        $newCollection = $paginator->getCollection()->map(function (Character $item)
        {
            return [
                'id' => $item->CharID,
                'text' => $item->CharName16 . ' - Level: ' . $item->CurLevel . ($item->NickName16 != '' ? " - JobName: *{$item->NickName16}" : ''),
            ];
        });

        $paginator->setCollection($newCollection);

        return $paginator;
    }
}
