<?php

namespace Modules\Core\Core\Enums;

enum DistrictEnum: string
{
    case ARIYALUR        = 'ariyalur';
    case CHENGALPATTU    = 'chengalpattu';
    case CHENNAI         = 'chennai';
    case COIMBATORE      = 'coimbatore';
    case CUDDALORE       = 'cuddalore';
    case DHARMAPURI      = 'dharmapuri';
    case DINDIGUL        = 'dindigul';
    case ERODE           = 'erode';
    case KALLAKURICHI    = 'kallakurichi';
    case KANCHIPURAM     = 'kanchipuram';
    case KANYAKUMARI     = 'kanyakumari';
    case KARUR           = 'karur';
    case KRISHNAGIRI     = 'krishnagiri';
    case MADURAI         = 'madurai';
    case MAYILADUTHURAI  = 'mayiladuthurai';
    case NAGAPATTINAM    = 'nagapattinam';
    case NAMAKKAL        = 'namakkal';
    case THE_NILGIRIS    = 'the_nilgiris';
    case PERAMBALUR      = 'perambalur';
    case PUDUKKOTTAI     = 'pudukkottai';
    case RAMANATHAPURAM  = 'ramanathapuram';
    case RANIPET         = 'ranipet';
    case SALEM           = 'salem';
    case SIVAGANGA       = 'sivaganga';
    case TENKASI         = 'tenkasi';
    case THANJAVUR       = 'thanjavur';
    case THENI           = 'theni';
    case TIRUVALLUR      = 'tiruvallur';
    case THOOTHUKUDI     = 'thoothukudi';
    case TIRUCHIRAPPALLI = 'tiruchirappalli';
    case TIRUNELVELI     = 'tirunelveli';
    case TIRUPATHUR      = 'tirupathur';
    case TIRUPPUR        = 'tiruppur';
    case TIRUVANNAMALAI  = 'tiruvannamalai';
    case TIRUVARUR       = 'tiruvarur';
    case VELLORE         = 'vellore';
    case VILUPPURAM      = 'viluppuram';
    case VIRUDHUNAGAR    = 'virudhunagar';

    public function label(): string
    {
        return match($this)
		{
            self::ARIYALUR        => 'Ariyalur',
            self::CHENGALPATTU    => 'Chengalpattu',
            self::CHENNAI         => 'Chennai',
            self::COIMBATORE      => 'Coimbatore',
            self::CUDDALORE       => 'Cuddalore',
            self::DHARMAPURI      => 'Dharmapuri',
            self::DINDIGUL        => 'Dindigul',
            self::ERODE           => 'Erode',
            self::KALLAKURICHI    => 'Kallakurichi',
            self::KANCHIPURAM     => 'Kanchipuram',
            self::KANYAKUMARI     => 'Kanyakumari',
            self::KARUR           => 'Karur',
            self::KRISHNAGIRI     => 'Krishnagiri',
            self::MADURAI         => 'Madurai',
            self::MAYILADUTHURAI  => 'Mayiladuthurai',
            self::NAGAPATTINAM    => 'Nagapattinam',
            self::NAMAKKAL        => 'Namakkal',
            self::THE_NILGIRIS    => 'The Nilgiris',
            self::PERAMBALUR      => 'Perambalur',
            self::PUDUKKOTTAI     => 'Pudukkottai',
            self::RAMANATHAPURAM  => 'Ramanathapuram',
            self::RANIPET         => 'Ranipet',
            self::SALEM           => 'Salem',
            self::SIVAGANGA       => 'Sivaganga',
            self::TENKASI         => 'Tenkasi',
            self::THANJAVUR       => 'Thanjavur',
            self::THENI           => 'Theni',
            self::TIRUVALLUR      => 'Tiruvallur',
            self::THOOTHUKUDI     => 'Thoothukudi',
            self::TIRUCHIRAPPALLI => 'Tiruchirappalli',
            self::TIRUNELVELI     => 'Tirunelveli',
            self::TIRUPATHUR      => 'Tirupathur',
            self::TIRUPPUR        => 'Tiruppur',
            self::TIRUVANNAMALAI  => 'Tiruvannamalai',
            self::TIRUVARUR       => 'Tiruvarur',
            self::VELLORE         => 'Vellore',
            self::VILUPPURAM      => 'Viluppuram',
            self::VIRUDHUNAGAR    => 'Virudhunagar',
        };
    }

    public static function asArray(): array
    {
        $array = [];
        foreach (self::cases() as $case) {
            $array[$case->value] = $case->label();
        }
        return $array;
    }
}
