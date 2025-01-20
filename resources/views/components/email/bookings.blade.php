<div style="background: #FAF8F5; padding: 16px 11px; border-radius: 8px; margin-top: 16px">
    <table style="width: 100%;">
        <thead>
            <tr>
                <th style="font-size: 14px; padding: 0px 20px; font-weight: 500; color: #585858; line-height: 20px;">{{ $emailFor == 'tutor' ? (setting('_lernen.student_display_name') ?? __('general.student')) : (setting('_lernen.tutor_display_name') ?? __('general.tutor')) }}</th>
                <th style="font-size: 14px; padding: 0px 20px; font-weight: 500; color: #585858; line-height: 20px;">{{ __('booking.subject') }}</th>
                <th style="font-size: 14px; padding: 0px 20px; font-weight: 500; color: #585858; line-height: 20px;">{{ __('calendar.date_time') }}</th>
            </tr>
        </thead>
        <tbody>
            @if(!empty($bookings))
                @foreach($bookings as $booking)
                    <tr>
                        @php
                            $img  = $emailFor == 'student' ? $booking['tutorImg'] : $booking['studentImg'];
                            $name = $emailFor == 'student' ? $booking['tutorName'] : $booking['studentName'];
                        @endphp
                        <td style="display: flex; align-items:center; gap: 10px; padding: 10px 20px;">
                            @if (!empty($img) && Storage::disk('public')->exists($img))
                                <img style="width: 36px; height: 36px; border-radius: 50%;"  src="{{ resizedImage($img, 40, 40) }}" alt="{{ $name }}">
                            @else
                                <img style="width: 36px; height: 36px; border-radius: 50%;"  src="{{ resizedImage('placeholder.png', 40, 40) }}" alt="{{ $name }}">
                            @endif
                            <h6 style="font-size: 14px; font-weight: 400; color: #585858; line-height: 20px; margin: 0;">{{ $name }}</h6>
                        </td>
                        <td style="font-size: 14px; padding: 10px 20px; font-weight: 400; color: #585858; line-height: 20px;">{!! $booking['subjectName'] !!} </td>
                        <td style="font-size: 14px; padding: 10px 20px; font-weight: 400; color: #585858; line-height: 20px;"><span style="display: block;">{!! $booking['sessionTime'] !!}</span></td>
                    </tr>
                @endforeach
            @endif    
        </tbody>
    </table>
</div>