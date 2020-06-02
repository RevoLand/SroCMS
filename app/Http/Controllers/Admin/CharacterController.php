<?php

namespace App\Http\Controllers\Admin;

use App\Character;
use App\DataTables\CharactersDataTable;
use App\GuildMember;
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
            $character->load(['user.account', 'guildmember']);
        }

        return view('characters.edit', [
            'character' => $character ?? '',
        ]);
    }

    public function updateBasicInfo(Character $character)
    {
        request()->validate([
            'level' => ['required', 'integer', 'min:1', 'max:140'],
            'strength' => ['required', 'integer', 'min:1', 'max:30000'],
            'intellect' => ['required', 'integer', 'min:1', 'max:30000'],
            'refobjid' => ['required', 'integer'],
            'gold' => ['required', 'integer', 'min:0', 'max:9000000000000000000'],
            'skillpoint' => ['required', 'integer', 'min:0', 'max:2000000000'],
            'statpoint' => ['required', 'integer', 'min:0', 'max:32000'],
            'inventorysize' => ['required', 'integer', 'min:45', 'max:109'],
        ]);

        $character->update([
            'CurLevel' => request('level'),
            'MaxLevel' => request('level'),
            'Strength' => request('strength'),
            'Intellect' => request('intellect'),
            'RefObjID' => request('refobjid'),
            'RemainGold' => request('gold'),
            'RemainSkillPoint' => request('skillpoint'),
            'RemainStatPoint' => request('statpoint'),
            'InventorySize' => request('inventorysize'),
        ]);

        return response()->json([
            'title' => 'Success!',
            'message' => 'Character\'s basic information has been successfully updated!',
            'icon' => 'success',
        ]);
    }

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
            'message' => 'Character Name / Job Name has been successfully updated!',
            'icon' => 'success',
        ]);
    }

    public function updateGuildmemberInfo(Character $character)
    {
        request()->validate([
            'nickname' => ['nullable',  'alpha_num', 'min:0', 'max:64'],
            'permission' => ['required', 'integer'],
        ]);

        $character->loadMissing('guildmember');

        if ($character->guildmember->MemberClass != GuildMember::OWNER)
        {
            $character->guildmember()->update([
                'Permission' => request('permission'),
            ]);
        }

        $character->guildmember()->update([
            'Nickname' => request('nickname'),
        ]);

        return response()->json([
            'title' => 'Success!',
            'message' => 'Character\'s guild info successfully updated.',
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

        $character->load(['user.account', 'guildmember']);

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

        $search = request()->validate(['search' => 'string|max:100'])['search'];

        $paginator = Character::select(['CharID', 'CharName16', 'NickName16', 'CurLevel'])
            ->where('CharName16', 'like', "{$search}%")
            ->orWhere('NickName16', 'like', "{$search}%")
            ->with('user.account:JID,StrUserID,Name')
            ->paginate(10);

        $newCollection = $paginator->getCollection()
            ->map(function (Character $item)
            {
                return [
                    'id' => $item->CharID,
                    'text' => "[{$item->user->account->StrUserID}] " . $item->CharName16 . ' - Level: ' . $item->CurLevel . ($item->NickName16 != '' ? " - JobName: *{$item->NickName16}" : ''),
                ];
            });

        $paginator->setCollection($newCollection);

        return $paginator;
    }
}
