<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class JobVacancy extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'company_name',
        'location',
        'employment_type',
        'workplace_type',
        'description',
        'responsibilities',
        'requirements',
        'salary_range',
        'application_deadline',
        'is_featured',
        'status',
        'published_at',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'application_deadline' => 'date',
            'published_at' => 'datetime',
            'is_featured' => 'boolean',
        ];
    }

    public function applications(): HasMany
    {
        return $this->hasMany(JobApplication::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopePublished($query)
    {
        return $query
            ->where('status', 'published')
            ->where(function ($query) {
                $query->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('application_deadline')
                    ->orWhereDate('application_deadline', '>=', today());
            });
    }

    protected static function booted(): void
    {
        static::creating(function (JobVacancy $vacancy) {
            if (blank($vacancy->slug)) {
                $vacancy->slug = static::generateUniqueSlug($vacancy->title);
            }
        });

        static::updating(function (JobVacancy $vacancy) {
            if ($vacancy->isDirty('title') && ! $vacancy->isDirty('slug')) {
                $vacancy->slug = static::generateUniqueSlug(
                    $vacancy->title,
                    $vacancy->id
                );
            }
        });
    }

    private static function generateUniqueSlug(
        string $title,
        ?int $ignoreId = null
    ): string {
        $base = Str::slug($title) ?: 'job';
        $slug = $base;
        $counter = 1;

        while (
            static::where('slug', $slug)
                ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $base . '-' . $counter++;
        }

        return $slug;
    }
}
