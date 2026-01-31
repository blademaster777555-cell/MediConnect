<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Specialization;

class AdminSpecializationController extends Controller
{
    // Hiển thị danh sách
    public function index() {
        $specializations = Specialization::all();
        return view('admin.specializations.index', compact('specializations'));
    }

    // Lưu chuyên khoa mới
    public function store(Request $request) {
        $request->validate([
            'name' => 'required|unique:specializations,name',
            'description' => 'nullable|string|max:1000'
        ]);

        Specialization::create([
            'name' => $request->name,
            'description' => $request->description
        ]);

        return redirect()->back()->with('success', __('Specialization added successfully!'));
    }

    // Hiển thị form chỉnh sửa
    public function edit($id) {
        $specialization = Specialization::findOrFail($id);
        return view('admin.specializations.edit', compact('specialization'));
    }

    // Cập nhật chuyên khoa
    public function update(Request $request, $id) {
        $specialization = Specialization::findOrFail($id);

        $request->validate([
            'name' => 'required|unique:specializations,name,' . $id,
            'description' => 'nullable|string|max:1000'
        ]);

        $specialization->update([
            'name' => $request->name,
            'description' => $request->description
        ]);

        return redirect()->route('specializations.index')->with('success', __('Specialization updated successfully!'));
    }

    // Xóa chuyên khoa
    public function destroy($id) {
        Specialization::destroy($id);
        return redirect()->back()->with('success', __('Specialization deleted successfully!'));
    }
}