<?php

namespace App\Http\Controllers\Admin;

use App\Enum\StatusEnum;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Attribute;
use Yajra\DataTables\Facades\DataTables;

class AttributeController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Attribute::orderBy('id', 'desc');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    $encryptedData = encrypt(json_encode([
                        'id' => $row->id,
                        'model' => 'Attribute'
                    ]));

                    $url = route('status.update', ['encryptModelNameID' => $encryptedData]);
                    $checked = $row->status == StatusEnum::ACTIVE ? 'checked' : '';

                    return '
                        <a href="javascript:void(0);" onclick="return changeStatus(\'' . $url . '\')">
                            <div class="form-check form-switch">
                                <input class="form-check-input status-toggle" type="checkbox" ' . $checked . '>
                            </div>
                        </a>
                    ';
                })

                ->addColumn('actions', function ($row) {
                    $deleteUrl = route('attributes.destroy', $row->id);
                    return '
                        <div class="dropdown">
                            <button class="btn btn-subtle-danger btn-icon btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item text-primary" href="javascript:void(0);" onclick="editAttribute(\'' . $row->id . '\')">
                                        <i class="bi bi-plus-circle align-baseline me-2"></i>Add Value
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item text-success" href="javascript:void(0);" onclick="editAttribute(\'' . $row->id . '\')">
                                        <i class="bi bi-pencil me-2"></i>Edit
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item text-danger" href="javascript:void(0);" onclick="confirmDelete(\'' . $deleteUrl . '\')">
                                        <i class="bi bi-trash me-2"></i>Delete
                                    </a>
                                </li>
                            </ul>
                        </div>
                    ';
                })


                ->rawColumns(['status', 'actions', 'image', 'status'])
                ->make(true);
        }
        $data = [
            'active' => 'attribute',
        ];
        return view('admin.attribute.index', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories,name',
        ]);

        $attribute = new Attribute();
        $attribute->name = $request->name;
        $attribute->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Attribute created successfully'
        ]);
    }

    public function edit(Request $request, $id)
    {
        sleep(2);
        $attribute = Attribute::find($id);
        return view('admin.attribute.edit', compact('attribute'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:attributes,name,' . $id,
        ]);
        $attribute = Attribute::find($id);
        $attribute->name = $request->name;
        $attribute->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Category updated successfully',
        ]);
    }

    public function destroy($id)
    {
        $attribute = Attribute::find($id)->delete();
        return response()->json(['success' => true]);
    }
}
