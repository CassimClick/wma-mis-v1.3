<?php
function showOption($arrayOne, $arrayTwo)
{
    $results = array_diff($arrayTwo, $arrayOne);

    return $results;
}


function multiDimensionArray(array $array): array
{
    $newArray = [];
    foreach ($array as $key => $value) {
        for ($i = 0; $i < count($value); $i++) {
            $newArray[$i][$key] = $value[$i];
        }
    }
    return array_values($newArray);
}

function fillArray($count, $variable): array
{
    return array_fill(0, $count, $variable);
}

function breakArray($array)
{
    foreach ($array as $item) {
        return $item;
    }
}

function totalAmount($theArray)
{

    $total = 0;

    foreach ($theArray as $item) {
        $amount = $item->amount;
        $total += $amount;
    }
    if ($total) {
        return number_format($total);
        // return $total;
    } else {
        return '0';
    }
}

function paidAmount($theArray)
{

    $paid = 0;

    foreach ($theArray as $item) {
        $amount = $item->amount;
        if ($item->payment == 'Paid') {
            $paid += $amount;
        }
    }
    if ($paid) {
        return number_format($paid);
    } else {
        return '0';
    }
}
function pendingAmount($theArray)
{

    $pending = 0;

    foreach ($theArray as $item) {

        $amount = $item->amount;
        if ($item->payment == 'Pending') {
            $pending += $amount;
        }
    }
    if ($pending) {
        return number_format($pending);
    } else {
        return '0';
    }
}

function instrumentQuantity($theArray)
{
    return count($theArray);
}
//=================helper to check all paid instruments====================
function paidInstruments($theArray)
{
    $instruments = [];
    foreach ($theArray as $item) {
        if ($item->payment == 'Paid') {
            array_push($instruments, $item);
        }
    }

    return number_format(count($instruments));
}
//=================helper to check all Unpaid instruments====================
function pendingInstruments($theArray)
{
    $instruments = [];
    foreach ($theArray as $item) {
        if ($item->payment == 'Pending') {
            array_push($instruments, $item);
        }
    }

    return number_format(count($instruments));
}

function paidSum($value)
{
    return str_replace(',', '', paidAmount($value));
}
function pendingSum($value)
{
    return str_replace(',', '', pendingAmount($value));
}
function totalCollection($value)
{
    return str_replace(',', '', totalAmount($value));
}

function meterQuantityAll($array)
{
    $totalMeters = 0;
    foreach ($array as $item) {
        $totalMeters += $item->quantity;
    }
    return $totalMeters;
}

function meterQuantityPaid($array)
{
    $paidMeters = 0;
    foreach ($array as $item) {
        if ($item->payment == 'Paid') {
            $paidMeters += $item->quantity;
        }
    }
    return $paidMeters;
}
function meterQuantityPending($array)
{
    $pendingMeters = 0;
    foreach ($array as $item) {
        if ($item->payment == 'Pending') {
            $pendingMeters += $item->quantity;
        }
    }
    return $pendingMeters;
}
function stringToInteger($str)
{
    return str_replace(',', '', $str);
}

function renderContacts($contacts)
{

    return ' Phone No: ' . $contacts->phone_number . ', Tel: ' . $contacts->tele_number . ', Fax: ' . $contacts->fax . ' , P.O Box ' . $contacts->postal_address . ', e-mail: ' . $contacts->email;
}


function countries(): array
{
    return [
        'Afghan',
        'Albanian',
        'Algerian',
        'American',
        'Andorran',
        'Angolan',
        'Antiguans',
        'Argentinean',
        'Armenian',
        'Australian',
        'Austrian',
        'Azerbaijani',
        'Bahamian',
        'Bahraini',
        'Bangladeshi',
        'Barbadian',
        'Barbudans',
        'Batswana',
        'Belarusian',
        'Belgian',
        'Belizean',
        'Beninese',
        'Bhutanese',
        'Bolivian',
        'Bosnian',
        'Brazilian',
        'British',
        'Bruneian',
        'Bulgarian',
        'Burkinabe',
        'Burmese',
        'Burundian',
        'Cambodian',
        'Cameroonian',
        'Canadian',
        'Cape Verdean',
        'Central African',
        'Chadian',
        'Chilean',
        'Chinese',
        'Colombian',
        'Comoran',
        'Congolese',
        'Costa Rican',
        'Croatian',
        'Cuban',
        'Cypriot',
        'Czech',
        'Danish',
        'Djibouti',
        'Dominican',
        'Dutch',
        'East Timorese',
        'Ecuadorean',
        'Egyptian',
        'Emirian',
        'Equatorial Guinean',
        'Eritrean',
        'Estonian',
        'Ethiopian',
        'Fijian',
        'Filipino',
        'Finnish',
        'French',
        'Gabonese',
        'Gambian',
        'Georgian',
        'German',
        'Ghanaian',
        'Greek',
        'Grenadian',
        'Guatemalan',
        'Guinea-Bissauan',
        'Guinean',
        'Guyanese',
        'Haitian',
        'Herzegovinian',
        'Honduran',
        'Hungarian',
        'I-Kiribati',
        'Icelander',
        'Indian',
        'Indonesian',
        'Iranian',
        'Iraqi',
        'Irish',
        'Israeli',
        'Italian',
        'Ivorian',
        'Jamaican',
        'Japanese',
        'Jordanian',
        'Kazakhstani',
        'Kenyan',
        'Kittian and Nevisian',
        'Kuwaiti',
        'Kyrgyz',
        'Laotian',
        'Latvian',
        'Lebanese',
        'Liberian',
        'Libyan',
        'Liechtensteiner',
        'Lithuanian',
        'Luxembourger',
        'Macedonian',
        'Malagasy',
        'Malawian',
        'Malaysian',
        'Maldivan',
        'Malian',
        'Maltese',
        'Marshallese',
        'Mauritanian',
        'Mauritian',
        'Mexican',
        'Micronesian',
        'Moldovan',
        'Monacan',
        'Mongolian',
        'Moroccan',
        'Mosotho',
        'Motswana',
        'Mozambican',
        'Namibian',
        'Nauruan',
        'Nepalese',
        'New Zealander',
        'Nicaraguan',
        'Nigerian',
        'Nigerien',
        'North Korean',
        'Northern Irish',
        'Norwegian',
        'Omani',
        'Pakistani',
        'Palauan',
        'Panamanian',
        'Papua New Guinean',
        'Paraguayan',
        'Peruvian',
        'Polish',
        'Portuguese',
        'Qatari',
        'Romanian',
        'Russian',
        'Rwandan',
        'Saint Lucian',
        'Salvadoran',
        'Samoan',
        'San Marinese',
        'Sao Tomean',
        'Saudi',
        'Scottish',
        'Senegalese',
        'Serbian',
        'Seychellois',
        'Sierra Leonean',
        'Singaporean',
        'Slovakian',
        'Slovenian',
        'Solomon Islander',
        'Somali',
        'South African',
        'South Korean',
        'Spanish',
        'Sri Lankan',
        'Sudanese',
        'Surinamer',
        'Swazi',
        'Swedish',
        'Swiss',
        'Syrian',
        'Taiwanese',
        'Tajik',
        'Tanzanian',
        'Thai',
        'Togolese',
        'Tongan',
        'Trinidadian/Tobagonian',
        'Tunisian',
        'Turkish',
        'Tuvaluan',
        'Ugandan',
        'Ukrainian',
        'Uruguayan',
        'Uzbekistani',
        'Venezuelan',
        'Vietnamese',
        'Welsh',
        'Yemenite',
        'Zambian',
        'Zimbabwean'
    ];
}




// function getSum($arr){
//     sum
// }