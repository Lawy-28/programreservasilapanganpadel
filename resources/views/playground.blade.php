@extends('layout')

@section('content')
<div class="card">
    <div class="card-header">
        <h2 class="card-title">UI Playground</h2>
        <span style="color: #666;">Experimental Area</span>
    </div>

    <div style="margin-bottom: 2rem;">
        <h3>Buttons</h3>
        <div style="display: flex; gap: 1rem; align-items: center;">
            <button class="btn btn-primary">Primary Button</button>
            <button class="btn btn-success">Success Button</button>
            <button class="btn btn-danger">Danger Button</button>
            <a href="#" class="btn" style="background-color: #ccc;">Neutral Button</a>
        </div>
    </div>

    <div style="margin-bottom: 2rem;">
        <h3>Form Inputs</h3>
        <form>
            <div class="form-group">
                <label>Text Input</label>
                <input type="text" class="form-control" placeholder="Sample text input">
            </div>
            <div class="form-group">
                <label>Select Input</label>
                <select class="form-control">
                    <option>Option 1</option>
                    <option>Option 2</option>
                </select>
            </div>
        </form>
    </div>

    <div style="margin-bottom: 2rem;">
        <h3>Alerts</h3>
        <div class="alert alert-success">
            This is a success alert message.
        </div>
        <div class="alert" style="background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb;">
            This is an error alert message.
        </div>
    </div>

    <div style="margin-bottom: 2rem;">
        <h3>Typography</h3>
        <h1>Heading 1</h1>
        <h2>Heading 2</h2>
        <h3>Heading 3</h3>
        <p>This is a standard paragraph text. It visually demonstrates the font family and size used in the application body.</p>
    </div>
</div>
@endsection
