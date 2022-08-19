@extends('layouts.app-admin')
@section('title', 'หมวดหมู่สินค้า')
@section('content')
    <div class="border-dark m-1 rounded border">
        <div class="row m-0">
            <div class="col-12 py-4">
                @include('component.admin-component.navigation')
                <hr class="border-top border-dark">
                <p>แก้ไขสินค้า</p>
                <hr class="border-top border-dark">
                @if (Session::get('success'))
                    <div class="alert alert-success">{{ Session::get('success') }}</div>
                @endif
                @if (Session::get('fail'))
                    <div class="alert alert-danger">{{ Session::get('fail') }}</div>
                @endif
                {!! Form::open(['route' => ['admin.product.update', $product->id], 'method' => 'put', 'files' => true]) !!}
                <div class="row m-0">
                    <div class="col-md-6 col-12 border-dark mb-3 rounded border p-2">
                        <img class="img-thumbnail d-block w-50 mx-auto" src="{{ Storage::url($product->image) }}" alt="">
                        <hr class="border-top border-dark">
                        <div class="form-group mb-3">
                            <label for="image">ภาพสินค้า</label>
                            <input name="image" type="file" class="form-control @error('image') is-invalid @enderror">
                            <span class="text-danger">
                                @error('image')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6 col-12 border-dark mb-3 rounded border p-2 text-center">
                        @foreach (json_decode($product->images, true) as $item)
                            <img class="img-thumbnail w-25 me-3 mb-3" src="{{ Storage::url($item) }}" alt="">
                        @endforeach
                        <hr class="border-top border-dark">
                        <div class="form-group mb-3">
                            <label for="images">ภาพสินค้าเพิ่มเติม (ไม่บังคับ)</label>
                            <input name="images[]" type="file" class="form-control @error('images') is-invalid @enderror" multiple>
                            <span class="text-danger">
                                @error('images')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6 col-12">
                        <div class="form-group mb-3">
                            <label for="code">รหัสสินค้า</label>
                            <input name="code" type="text" class="form-control @error('code') is-invalid @enderror" value="{{ $product->code }}" readonly disabled>
                            <span class="text-danger">
                                @error('code')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="form-group mb-3">
                            <label for="product_name">ชื่อสินค้า</label>
                            <input name="product_name" type="text" class="form-control @error('product_name') is-invalid @enderror" value="{{ $product->product_name }}">
                            <span class="text-danger">
                                @error('product_name')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="form-group mb-3">
                            <label for="category">หมวดหมู่สินค้า</label>
                            <select name="category" id="category" class="form-select @error('category') is-invalid @enderror">
                                <option value="{{ $product->category }}">{{ getParentForSelect($product->category) }}</option>
                                @foreach ($category as $item)
                                    <option value="{{ $item->id }}">{{ getParentForSelect($item->id) }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger">
                                @error('category')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                    </div>
                    <div class="col-lg-1 col-md-4 col-6">
                        <div class="form-group mb-3">
                            <label for="color">สี</label>
                            <select name="color" id="color" class="form-select @error('color') is-invalid @enderror">
                                <option value="{{ $product->color }}">{{ $product->color }}</option>
                                <option value="-">-</option>
                                <option value="ขาว">ขาว</option>
                                <option value="ดำ">ดำ</option>
                                <option value="น้ำเงิน">น้ำเงิน</option>
                                <option value="แดง">แดง</option>
                                <option value="ฟ้า">ฟ้า</option>
                                <option value="เหลือง">เหลือง</option>
                                <option value="เขียว">เขียว</option>
                                <option value="ส้ม">ส้ม</option>
                                <option value="ม่วง">ม่วง</option>
                                <option value="ชมพู">ชมพู</option>
                                <option value="เงิน">เงิน</option>
                                <option value="ทอง">ทอง</option>
                                <option value="น้ำตาล">น้ำตาล</option>
                                <option value="ขาว">ขาว</option>
                                <option value="ขาว">ขาว</option>
                                <option value="ไม้">ไม้</option>
                                <option value="ไม้โอ๊ค">ไม้โอ๊ค</option>
                                <option value="กรมท่า">กรมท่า</option>
                                <option value="กากี">กากี</option>
                                <option value="โอรส">โอรส</option>
                                <option value="ชาด">ชาด</option>
                            </select>
                            <span class="text-danger">
                                @error('color')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-6">
                        <div class="form-group mb-3">
                            <label for="amount">จำนวนที่มี</label>
                            <input name="amount" type="number" class="form-control @error('amount') is-invalid @enderror" value="{{ $product->amount }}" step="1" min="0">
                            <span class="text-danger">
                                @error('amount')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="form-group mb-3">
                            <label for="remain">แจ้งเตือนเติมสต๊อกเมื่อสินค้าเหลือต่ำกว่า</label>
                            <input name="remain" type="number" class="form-control @error('remain') is-invalid @enderror" value="{{ $product->remain }}" step="1" min="0">
                            <span class="text-danger">
                                @error('remain')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-6">
                        <div class="form-group mb-3">
                            <label for="price">ราคา</label>
                            <input name="price" type="number" class="form-control @error('price') is-invalid @enderror" value="{{ $product->price }}" step="0.01" min="0">
                            <span class="text-danger">
                                @error('price')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-6">
                        <div class="form-group mb-3">
                            <label for="discount">สถานะการขาย</label>
                            <select name="discount" id="discount" class="form-select @error('discount') is-invalid @enderror">
                                <option value="{{ $product->discount }}">{{ getDiscountMode($product->discount) }}</option>
                                @foreach (getDiscountMode() as $key => $item)
                                    <option value="{{ $key }}">{{ $item }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger">
                                @error('discount')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-6">
                        <div class="form-group mb-3">
                            <label for="dis_price">จำนวนลดราคา</label>
                            <input name="dis_price" type="number" class="form-control @error('dis_price') is-invalid @enderror" value="{{ $product->dis_price }}" step="0.01" min="0">
                            <span class="text-danger">
                                @error('dis_price')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group mb-3">
                            <label for="product_details">รายละเอียดสินค้า</label>
                            <textarea name="product_details">{{ $product->product_details }}</textarea>
                            <span class="text-danger">
                                @error('product_details')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                    </div>
                    <hr class="border-top border-dark">
                    <div class="d-grid gap-2">
                        {!! Form::submit('บันทึกข้อมูล', ['class' => 'btn btn-success']) !!}
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <script>
        CKEDITOR.replace('product_details', {
            height: 400
        });
    </script>
@endsection
