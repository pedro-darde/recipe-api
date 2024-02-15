<?php

namespace App\Enums;

enum RecipeDifficulty: string
{
    case EASY = 'easy';
    case MEDIUM = 'medium';
    case HARD = 'hard';
    case PROFESSIONAL = 'professional';
}