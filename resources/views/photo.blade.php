<form action="/upload" method="post" accept=".xls,.xlsx" enctype="multipart/form-data">
        {{csrf_field()}}
        <p>
            <input type="file" name="excel" id="excel">
        </p>
        <p>
            <input type="submit" value="提交">
        </p>
</form>