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
            self::SENANG => [
                'target_valence' => 0.9,
                'target_energy' => 0.8,
                'min_danceability' => 0.7,
                'max_tempo' => 150
            ],
            self::SEDIH => [
                'target_valence' => 0.2,
                'max_energy' => 0.3,
                'max_tempo' => 100
            ],
            self::MARAH => [
                'target_valence' => 0.3,
                'target_energy' => 0.9,
                'min_tempo' => 120
            ],
            self::TAKUT => [
                'target_valence' => 0.2,
                'target_mode' => 0,
                'max_energy' => 0.5
            ],
            self::CINTA => [
                'target_valence' => 0.8,
                'target_energy' => 0.6,
                'min_acousticness' => 0.3
            ],
            self::JIJIK => [
                'target_valence' => 0.1,
                'target_energy' => 0.4,
                'min_instrumentalness' => 0.2
            ],
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
