<?php

namespace App\Http\Controllers\Admin;

use App\Enum\StatusEnum;
use App\Models\Attribute;
use Illuminate\Http\Request;
use App\Models\AttributeValue;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class AttributeValueController extends Controller
{
    public function index(Request $request)
    {
        $attributeId = decrypt($request->attribute_id);
        $data = AttributeValue::with('attribute')->where('attribute_id', $attributeId)->orderBy('id', 'desc');
        $attribute = Attribute::select('id', 'name')->find($attributeId);
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    $encryptedData = encrypt(json_encode([
                        'id' => $row->id,
                        'model' => 'AttributeValue'
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
                    $deleteUrl = route('attribute-values.destroy', $row->id);
                    return '
                        <div class="dropdown">
                            <button class="btn btn-subtle-danger btn-icon btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu">
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
            'title' => 'Attributes',
            'attribute' => $attribute
        ];
        return view('admin.attribute-value.index', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'value' => 'required|string|max:255',
        ]);

        $attribute_value = new AttributeValue();
        $attribute_value->attribute_id = $request->attribute_id;
        $attribute_value->value = $request->value;
        $attribute_value->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Attribute value created successfully'
        ]);
    }

    public function edit(Request $request, $id)
    {
        $attributeValue = AttributeValue::find($id);
        return view('admin.attribute-value.edit', compact('attributeValue'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'value' => 'required|string|max:255',
        ]);
        $attribute = AttributeValue::find($id);
        $attribute->value = $request->value;
        $attribute->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Category updated successfully',
        ]);
    }

    public function destroy($id)
    {
        $attributeValue = AttributeValue::find($id)->delete();
        return response()->json(['success' => true]);
    }
}
