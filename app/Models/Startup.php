<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Startup extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'logo',
        'location',
        'industry',
        'stage',
        'funding',
        'funding_round',
        'description',
        'website',
        'team_members',
        'technologies',
        'metrics'
    ];

    protected $casts = [
        'funding' => 'decimal:2',
        'team_members' => 'array',
        'technologies' => 'array',
        'metrics' => 'array'
    ];

    public function investors()
    {
        return $this->belongsToMany(Investor::class, 'startup_investor')
            ->withPivot('investment_amount', 'investment_date', 'equity_stake')
            ->withTimestamps();
    }

    public function newsArticles()
    {
        return $this->belongsToMany(NewsArticle::class, 'startup_news_article')
            ->withTimestamps();
    }

    public function getFormattedFundingAttribute()
    {
        return '$' . number_format($this->funding, 2) . 'M';
    }

    public function getStageBadgeClassAttribute()
    {
        return match($this->stage) {
            'Seed' => 'badge-warning',
            'Series A' => 'badge-primary',
            'Series B', 'Series C', 'Growth' => 'badge-success',
            default => 'badge-secondary'
        };
    }
} 