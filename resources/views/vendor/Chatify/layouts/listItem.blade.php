{{-- -------------------- Contact list -------------------- --}}
@if ($get == 'users' && !!$lastMessage)
    <?php
    $lastMessageBody = mb_convert_encoding($lastMessage->body, 'UTF-8', 'UTF-8');
    $lastMessageBody = strlen($lastMessageBody) > 30 ? mb_substr($lastMessageBody, 0, 30, 'UTF-8') . '..' : $lastMessageBody;
    ?>
    <table class="messenger-list-item" data-contact="{{ $user->id }}">
        <tr data-action="0">
            {{-- Avatar side --}}
            <td style="position: relative">
                @if ($user->active_status)
                    <span class="activeStatus"></span>
                @endif
                <div class="avatar av-m" style="background-image: url('{{ $user->profile_image }}');">
                    <img style="width:80px; height:60px"
                        src=" {{ !empty($user->profile_image) ? url('uploads/admin_images/' . $user->profile_image) : url('uploads/no_image.jpg') }}"
                        alt="">
                </div>
            </td>

            {{-- center side --}}
            <td>


                <p data-id="{{ $user->id }}" data-type="user">
                    {{ strlen($user->name) > 12 ? trim(substr($user->name, 0, 12)) . '..' : $user->name }}
                    <span class="contact-item-time"
                        data-time="{{ $lastMessage->created_at }}">{{ $lastMessage->timeAgo }}</span>

                </p>


                <div class="">
                    <span>
                        Ortu Dari :
                    </span>
                </div>
                <span>
                    {{-- Last Message user indicator --}}
                    {!! $lastMessage->from_id == Auth::user()->id ? '<span class="lastMessageIndicator">You :</span>' : '' !!}
                    {{-- Last message body --}}
                    @if ($lastMessage->attachment == null)
                        {!! $lastMessageBody !!}
                    @else
                        <span class="fas fa-file"></span> Attachment
                    @endif
                </span>
                {{-- New messages counter --}}
                {!! $unseenCounter > 0 ? '<b>' . $unseenCounter . '</b>' : '' !!}
            </td>
        </tr>
    </table>
@endif
