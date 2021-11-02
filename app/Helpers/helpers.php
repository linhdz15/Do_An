<?php

use Illuminate\Support\Facades\Request;
use App\Actions\Image\ImageService;

/**
 * Add css class when link is currently active
 *
 * @param array|string $path Single path or array of paths
 * @param string $activeClass Default is 'active'
 * @return string
 */
function active_link($path, $activeClass = 'active')
{
    return Request::is($path) ? $activeClass : '';
}

/**
 * Check if an input has error, e.g. validation errors from Laravel
 *
 * @param array|string $fields Input fields name
 * @param \Illuminate\Support\MessageBag $errors
 * @param string $errorCssClass   Css class when field has error
 *
 * @return string
 */
function has_error($fields, $errors, $errorCssClass = 'has-danger')
{
    return $errors->hasAny($fields) ? $errorCssClass : '';
}

function selected_select2_values($selectedValues)
{
    return is_array($selectedValues) ? implode(',', $selectedValues) : $selectedValues;
}

function selected_select_value($selectedKey, $selectedValue)
{
    return request()->get($selectedKey) == $selectedValue ? 'selected' : '';
}

function uploaded_image_url($uploadedPath)
{
    return $uploadedPath ? app()->make(ImageService::class)->uploadedImageUrl($uploadedPath) : null;
}

function uploaded_resized_image_url($uploadedPath, $size)
{
    return $uploadedPath ? app()->make(ImageService::class)->resizedImageUrl($uploadedPath, $size) : null;
}

function escapeLike(?string $string, $expPercent = false): string
{
    if ($expPercent) {
        $search = ['\\', '_', '&', '|'];
        $replace = ['\\\\', '\_', '\&', '\|'];
    } else {
        $search = ['\\', '%', '_', '&', '|'];
        $replace = ['\\\\', '\%', '\_', '\&', '\|'];
    }

    return str_replace($search, $replace, $string);
}

/**
 * Return string.
 */
function getCurWeekDay(): string
{
    date_default_timezone_set('Asia/Ho_Chi_Minh');

    $weekday = date('l');
    $weekday = strtolower($weekday);

    switch ($weekday) {
        case 'monday':
            $weekday = 'Thứ hai';
            break;
        case 'tuesday':
            $weekday = 'Thứ ba';
            break;
        case 'wednesday':
            $weekday = 'Thứ tư';
            break;
        case 'thursday':
            $weekday = 'Thứ năm';
            break;
        case 'friday':
            $weekday = 'Thứ sáu';
            break;
        case 'saturday':
            $weekday = 'Thứ bảy';
            break;
        default:
            $weekday = 'Chủ nhật';
            break;
    }

    return $weekday . ', ' . date('d/m/Y');
}

function time_elapsed_string($time)
{
    $time = time() - strtotime($time); // to get the time since that moment
    $time = ($time < 1) ? 1 : $time;
    $tokens = array(
        31536000 => 'năm',
        2592000 => 'tháng',
        604800 => 'tuần',
        86400 => 'ngày',
        3600 => 'giờ',
        60 => 'phút',
        1 => 'giây'
    );

    foreach ($tokens as $unit => $text) {
        if ($time < $unit) continue;
        $numberOfUnits = floor($time / $unit);
        return $numberOfUnits . ' ' . $text . ' trước';
    }
}

function html_clean($content = '')
{
    return preg_replace('/[\s]+/mu', ' ', html_entity_decode(strip_tags($content)));
}
