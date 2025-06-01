<?php

namespace App\Enums;

enum Emotion: string
{
    case SENANG = 'senang';
    case SEDIH = 'sedih';
    case MARAH = 'marah';
    case TAKUT = 'takut';
    case CINTA = 'cinta';
    case JIJIK = 'jijik';

    public function toSpotifyParams(): array
    {
        return match ($this) {
            self::SENANG => ['valence' => 0.9, 'energy' => 0.8],
            self::SEDIH => ['valence' => 0.2, 'energy' => 0.3],
            self::MARAH => ['valence' => 0.3, 'energy' => 0.9],
            self::TAKUT => ['valence' => 0.2, 'mode' => 0],
            self::CINTA => ['valence' => 0.8, 'energy' => 0.6],
            self::JIJIK => ['valence' => 0.1, 'energy' => 0.4],
        };
    }

    public static function fromString(string $value): ?self
    {
        return match (strtolower($value)) {
            'senang' => self::SENANG,
            'sedih' => self::SEDIH,
            'marah' => self::MARAH,
            'takut' => self::TAKUT,
            'cinta' => self::CINTA,
            'jijik' => self::JIJIK,
            default => null,
        };
    }
}
