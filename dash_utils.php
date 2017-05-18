<?php

    function memberFor ($pastdate) {
        $diff = fromPastToNow($pastdate, 'Y/m/d');
        
        return formatDate($diff);
    };

    function lastSeen ($logindate) {
        $diff = fromPastToNow($logindate, 'Y/m/d G:i:s');
        
        return formatDateAndHours($diff, $logindate);
    };
    
    function fromPastToNow($pastdate, $pattern) {
        $date1 = new DateTime($pastdate);
        $date2 = new DateTime(date($pattern));
        $diff = $date2 -> diff($date1, true);
        
        return $diff;
    };
    
    function formatDate ($diff) {
        $memberfor = '';
        
        $years = $diff -> format('%y');
        if ($years > 0) {
            $memberfor = $memberfor . $years . ' year'. (($years == 1) ? '' : 's');
        }
        
        $months = $diff -> format('%m');
        if ($months > 0) {
            $memberfor = $memberfor . (($years > 0) ? ' and ' : '') . $months . ' month' . (($months == 1) ? '' : 's');
        }
        
        if ($months == 0 && $years == 0) {
            $days = $diff -> format('%d');
            if ($days > 1) {
                $memberfor = $memberfor . $days . ' day'. (($days == 1) ? '' : 's');
            } else if ($days == 1) {
                $memberfor = 'Yesterday';
            } else {
                $memberfor = 'Today';
            }
        }

        return $memberfor;
    };
    
    function formatDateAndHours ($diff, $logindate) {
        $lastseen = '';
        
        $days = $diff -> format('%d');
        $hours = $diff -> format('%h');
        
        if ($days == 0 && $hours >= 0) {
            if ($hours == 0) {
                $lastseen = 'Now';
            } else {
                $lastseen = $lastseen . $hours . ' hour'. (($hours == 1) ? ' ago' : 's ago');
            }
        } else {
            $lastseen = memberFor($logindate);
            if (trim($lastseen) != 'Yesterday' && trim($lastseen) != 'Today') {
                $lastseen = $lastseen . ' ago';
            }
        }
        
        return $lastseen;
    };

?>











