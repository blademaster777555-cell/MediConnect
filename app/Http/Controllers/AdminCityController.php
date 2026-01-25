<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\City;

class AdminCityController extends Controller
{
    // Hiển thị danh sách
    public function index() {
        $cities = City::all();
        return view('admin.cities.index', compact('cities'));
    }

    // Lưu thành phố mới
    public function store(Request $request) {
        $request->validate(['name' => 'required|unique:cities,name']);
        City::create(['name' => $request->name]);
        return redirect()->back()->with('success', __('Thêm thành phố thành công!'));
    }

    // Hiển thị form chỉnh sửa
    public function edit($id) {
        $city = City::findOrFail($id);
        return view('admin.cities.edit', compact('city'));
    }

    // Cập nhật thành phố
    public function update(Request $request, $id) {
        $city = City::findOrFail($id);
        $request->validate(['name' => 'required|unique:cities,name,' . $id]);
        $city->update(['name' => $request->name]);
        return redirect()->route('admin.cities.index')->with('success', __('Cập nhật thành phố thành công!'));
    }

    // Xóa thành phố
    public function destroy($id) {
        City::destroy($id);
        return redirect()->back()->with('success', __('Đã xóa thành phố!'));
    }
}