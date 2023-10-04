<?php

namespace App\Http\Controllers;

use App\Models\Oui;
use Illuminate\Http\Request;

class JsonApiController extends Controller
{
    public function lookupSingleMac($mac)
    {
        $normalisedMac = $this->normaliseMac($mac);
        
        return response()->json([
            'mac_address' => $normalisedMac,
            'vendor' => $this->lookupVendor($normalisedMac)
        ]);
    }

    public function lookupMultipleMacs(Request $request)
    {
        $macs = $request->input('macs');
        $results = [];

        foreach ($macs as $mac) {
            $normalisedMac = $this->normaliseMac($mac);

            $results[] = [
                'mac_address' => $normalisedMac,
                'vendor' => $this->lookupVendor($normalisedMac),
            ];
        }

        return response()->json(['results' => $results]);
    }

    private function lookupVendor($mac)
    {
        // Check for MAC randomisation
        $randomisedPrefixes = ['2', '6', 'A', 'E'];
        $isRandomised = in_array(substr($mac, 1, 1), $randomisedPrefixes);

        // Exclude the last 6 characters for lookup if not randomised
        $filteredMac = $isRandomised ? $mac : substr($mac, 0, -6);

        $oui = Oui::where('assignment', $filteredMac)->first();
        return $oui ? $oui->getOrganizationName() : 'Vendor not found';
    }

    private function normaliseMac($mac)
    {
        // Normalise MAC address by removing separators and converting to uppercase
        return strtoupper(preg_replace('/[.:\\-]/', '', $mac));
    }
}
