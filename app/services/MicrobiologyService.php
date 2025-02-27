<?php namespace App\services;

use App\Http\Controllers\AdminAuth\Microbiology\MicroController;
use App\MicrobialEfficacyAnalyses;
use App\MicrobialLoadAnalyses;
use App\Product;

class MicrobiologyService extends MicroController{

    public function getMicrobialLoadAnalysis($admin) {
        $loadAnalysisOptions = json_decode($admin->load_analysis_options);
        return MicrobialLoadAnalyses::whereIn('id', $loadAnalysisOptions)->orderBy('location', 'ASC')->get();
    }

    public function getMicrobialEfficacyAnalysis($admin) {
        $efficacyAnalysisOptions = json_decode($admin->efficacy_analysis_options);
        return MicrobialEfficacyAnalyses::whereIn('id', $efficacyAnalysisOptions)->get();
    }

    public function getMicroproducts($deptId, $status) {
        return Product::with('departments')
            ->whereHas('departments', fn($q) => $q->where('dept_id', $deptId)->where('status', $status))
            ->with(['loadAnalyses', 'efficacyAnalyses'])
            ->whereDoesntHave('loadAnalyses')
            ->whereDoesntHave('efficacyAnalyses')
            ->orderBy('id', 'DESC')
            ->get();
    }

    public function getMicroproductsWithTests($deptId, $status) {
        $withLoad = $this->getProductsWithLoadAnalysis($deptId, $status);
        $withEfficacy = $this->getProductsWithEfficacyAnalysis($deptId, $status);
        return $withLoad->merge($withEfficacy);
    }

    public function getAuthMicroproductsWithTests($adminId, $deptId, $status) {
        $withLoad = $this->getAuthProductsWithLoadAnalysis($adminId, $deptId, $status);
        $withEfficacy = $this->getAuthProductsWithEfficacyAnalysis($adminId, $deptId, $status);
        return $withLoad->merge($withEfficacy);
    }

    public function getCompletedTests($deptId, $status) {
        return Product::with('departments')
            ->whereHas('departments', fn($q) => $q->where('dept_id', $deptId)->where('status', $status))
            ->limit(10)
            ->get();
    }

    private function getProductsWithLoadAnalysis($deptId, $status) {
        return Product::with('departments')
            ->whereHas('departments', fn($q) => $q->where('dept_id', $deptId)->where('status', $status))
            ->with('loadAnalyses')
            ->whereHas('loadAnalyses')
            ->with('efficacyAnalyses')
            ->get();
    }

    private function getProductsWithEfficacyAnalysis($deptId, $status) {
        return Product::with('departments')
            ->whereHas('departments', fn($q) => $q->where('dept_id', $deptId)->where('status', $status))
            ->with('efficacyAnalyses')
            ->whereHas('efficacyAnalyses')
            ->get();
    }

    private function getAuthProductsWithLoadAnalysis($adminId, $deptId, $status) {
        return Product::where('micro_analysed_by', $adminId)
            ->with('departments')
            ->whereHas('departments', fn($q) => $q->where('dept_id', $deptId)->where('status', $status))
            ->with('loadAnalyses')
            ->whereHas('loadAnalyses')
            ->with('efficacyAnalyses')
            ->get();
    }

    private function getAuthProductsWithEfficacyAnalysis($adminId, $deptId, $status) {
        return Product::where('micro_analysed_by', $adminId)
            ->with('departments')
            ->whereHas('departments', fn($q) => $q->where('dept_id', $deptId)->where('status', $status))
            ->with('efficacyAnalyses')
            ->whereHas('efficacyAnalyses')
            ->get();
    }
}
?>
