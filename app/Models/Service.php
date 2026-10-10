<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'short_description',
        'description',
        'image',
        'subsidiary_id',
        'features',
        'status',
        'sort_order',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'og_title',
        'og_description',
        'twitter_title',
        'twitter_description',
    ];

    protected $casts = [
        'features' => 'array',
        'status' => 'boolean',
    ];

    public function subsidiary()
    {
        return $this->belongsTo(Subsidiary::class);
    }

    /**
     * Automatically generate slug if not supplied.
     */
    protected static function booted(): void
    {
        static::creating(function ($service) {
            if (empty($service->slug)) {
                $service->slug = static::generateUniqueSlug($service->name);
            }
        });

        static::updating(function ($service) {
            if (empty($service->slug)) {
                $service->slug = static::generateUniqueSlug(
                    $service->name,
                    $service->id
                );
            }
        });
    }

    public static function generateUniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $counter = 1;

        while (
            static::query()
                ->where('slug', $slug)
                ->when($ignoreId, function ($query) use ($ignoreId) {
                    $query->where('id', '!=', $ignoreId);
                })
                ->exists()
        ) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    public function subsidiaryCompany()
    {
        return $this->belongsTo(
            SubsidiaryCompany::class,
            'subsidiary_company_id'
        );
    }
}
