<x-filament-panels::page>
    @php
        $stats = $this->getSystemStats();
        $selectedPeriode = request('periode_id');
        $monthlyStats = $this->getMonthlyStats($selectedPeriode);
    @endphp
        

</x-filament-panels::page>
