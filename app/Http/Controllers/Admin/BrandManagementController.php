<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BrandRequest;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BrandManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->s == null)
            $brands = Brand::paginate(10);
        else
            $brands = Brand::where('name', 'LIKE', '%' . $request->s . '%')->paginate(10);
        $searchString = $request->s != null ? $request->s : null;
        return view('admin.brand.index', compact('searchString', 'brands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.brand.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BrandRequest $request)
    {
        if ($request->hasFile('photo')) {
            if ($request->photo->getSize() > 1024 * 1024)
                return back()->with('error', 'Hình ảnh tải lên không được lớn hơn 1MB');
            $brand = $request->except('_token');
            $brand['slug'] = Str::slug($brand['name']) . date('Hisdmy');
            $fileName = $brand['slug'] . '.' . $request->photo->extension();
            $brand['photo'] = 'brand/' . $fileName;
            Storage::putFileAs('public', $request->photo, $brand['photo']);
            Brand::create($brand);
            return back()->with('success', 'Thêm thương hiệu thành công');
        }
        return back()->with('error', 'Vui lòng chọn ảnh để tải lên');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $brand = Brand::find($id);
        return view('admin.brand.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BrandRequest $request, int $id)
    {
        $brand = $request->except('_token');
        $brand['slug'] = Str::slug($brand['name']) . date('Hisdmy');
        if ($request->hasFile('photo')) {
            if ($request->photo->getSize() > 1024 * 1024)
                return back()->with('error', 'Hình ảnh tải lên không được lớn hơn 1MB');

            $fileName = $brand['slug'] . '.' . $request->photo->extension();
            $brand['photo'] = 'brand/' . $fileName;
            Storage::putFileAs('public', $request->photo, $brand['photo']);
        }
        Brand::where('id', $id)->update($brand);
        return back()->with('success', 'Chỉnh sửa thương hiệu thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        try {
            Brand::destroy($id);
        } catch (\Throwable $th) {
            return back()->with('error', 'Có lỗi xảy ra, vui lòng thử lại');
        }
        return back()->with('success', 'Xóa thương hiệu thành công');
    }
}
