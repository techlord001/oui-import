<?php

namespace App\Http\Controllers;

use App\Models\Oui;
use Illuminate\Http\Request;

class JsonApiController extends Controller
{
    public function lookupSingleMac($mac)
    {
        $normalisedMac = strtoupper(preg_replace('/[.:\\-]/', '', $mac));
        
        return response()->json([
            'mac_address' => $normalisedMac,
            'vendor' => $this->lookupVendor($normalisedMac)
        ]);
    }

    private function lookupVendor($mac)
    {
        // Check for MAC randomization
        $randomizedPrefixes = ['2', '6', 'A', 'E'];
        $isRandomized = in_array(substr($mac, 1, 1), $randomizedPrefixes);

        // Exclude the last 6 characters for lookup if not randomized
        $filteredMac = $isRandomized ? $mac : substr($mac, 0, -6);

        $oui = Oui::where('assignment', $filteredMac)->first();
        return $oui ? $oui->getOrganizationName() : 'Vendor not found';
    }
}
