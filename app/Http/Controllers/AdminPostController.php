<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Post;

class AdminPostController extends Controller
{
    // 1. Xem danh sách bài viết
    public function index() {
        $posts = Post::latest()->paginate(10);
        return view('admin.posts.index', compact('posts'));
    }

    // 2. Mở form viết bài mới
    public function create() {
        return view('admin.posts.create');
    }

    // 3. Lưu bài viết vào CSDL
    public function store(Request $request) {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'type' => 'required', // news, disease, invention
        ]);

        // Xử lý tạo slug tự động từ tiêu đề (VD: Tên Bài -> ten-bai)
        $slug = \Str::slug($request->title) . '-' . time();

        Post::create([
            'title' => $request->title,
            'slug' => $slug,
            'summary' => $request->summary,
            'content' => $request->content,
            'image' => $request->image, // Tạm thời nhập link ảnh, sau này nâng cấp upload file sau
            'type' => $request->type,
        ]);

        return redirect()->route('posts.index')->with('success', 'Đăng bài thành công!');
    }
    
    // 4. Xóa bài
    public function destroy($id) {
        Post::destroy($id);
        return redirect()->back()->with('success', 'Đã xóa bài viết');
    }
}