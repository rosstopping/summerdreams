<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $eventNameMap = [
            'Sunset Yacht Party' => 'Nissi Beach Party',
            'Sunset Boat Party' => 'Nissi Beach Party',
            'Projekt Live' => 'Projekt Live with Nathan Dawe',
            'Projekt Live w/ Nathan Dawe' => 'Projekt Live with Nathan Dawe',
            'Pambos Pool Party' => 'PAMBOS',
            'Pambo\'s Pool Party' => 'PAMBOS',
            'Vice Parties' => 'Vice Parties On The Roof',
            'Vice' => 'Vice Parties On The Roof',
            'Carnage Bar Crawl & Afterparty' => 'Sunset YACHT Party',
            'Carnage Bar Crawl' => 'Sunset YACHT Party',
            'Sunset Sessions' => 'Sunset Sessions Pool Party',
            'Sunday Sessions' => 'Sunset Sessions Pool Party',
        ];

        foreach ($eventNameMap as $oldName => $newName) {
            DB::table('events')
                ->where('name', $oldName)
                ->update([
                    'name' => $newName,
                    'updated_at' => now(),
                ]);
        }

        $this->updatePackageIncludes($eventNameMap);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $eventNameMap = [
            'Nissi Beach Party' => 'Sunset Yacht Party',
            'Projekt Live with Nathan Dawe' => 'Projekt Live w/ Nathan Dawe',
            'PAMBOS' => 'Pambos Pool Party',
            'Vice Parties On The Roof' => 'Vice Parties',
            'Sunset YACHT Party' => 'Carnage Bar Crawl',
            'Sunset Sessions Pool Party' => 'Sunset Sessions',
        ];

        foreach ($eventNameMap as $oldName => $newName) {
            DB::table('events')
                ->where('name', $oldName)
                ->update([
                    'name' => $newName,
                    'updated_at' => now(),
                ]);
        }

        $this->updatePackageIncludes($eventNameMap);
    }

    private function updatePackageIncludes(array $eventNameMap): void
    {
        $packages = DB::table('packages')->select('id', 'includes')->get();

        foreach ($packages as $package) {
            $includes = json_decode($package->includes ?? '[]', true);

            if (!is_array($includes)) {
                continue;
            }

            $updatedIncludes = array_map(function ($include) use ($eventNameMap) {
                if (!is_string($include)) {
                    return $include;
                }

                return $eventNameMap[$include] ?? $include;
            }, $includes);

            if ($updatedIncludes === $includes) {
                continue;
            }

            DB::table('packages')
                ->where('id', $package->id)
                ->update([
                    'includes' => json_encode($updatedIncludes),
                    'updated_at' => now(),
                ]);
        }
    }
};
