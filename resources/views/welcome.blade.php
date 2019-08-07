<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="{{url('css/styles.css')}}">
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <br><br>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="row">
                <form action="{{route('save')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <input type="file" name="Upload" id="" accept=".pdf"/>
                    </div>
                    <div class="switch">
                        <label>
                            <input type="checkbox" id="StatusOn"  value="1" onchange="Changeactive(this.value)"  />
                            <span class="lever"></span>
                            <input type="hidden" name="CompanyStatus" id="companyStatus" value='0' />
                            <label>Convert To Single</label>
                        </label>
                    </div> 
                    <div class="from-group">
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </form>
            </div>
            <hr>
            <div class="row"><h4 class="text-success">Upload Pdf With Images</h4></div>
            <hr>
            <div class="row">
                <table class="table">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Pdf Name</th>
                        <th scope="col">Pdf Images</th>
                        <th scope="col">Single Image</th>
                    </tr>
                    </thead>
                    <tbody>
                        @if (count($UploadedData)>0)
                            <?php $count=1;?>
                            @foreach ($UploadedData as $item)
                            <tr>
                                <?php $pdfname = explode('/',$item->PdfName)?>
                            <th scope="row">{{$count}}</th>
                            <td>{{$pdfname[3]}}</td>
                            <td>
                                @if (count($item->images)>0)
                                <ul>
                                    @foreach ($item->images as $images)
                                    <?php $imagename = explode('/',$images->ImageName)?>
                                        <li><a href="{{ url($images->ImageName)}}" target="_blank">{{$imagename[2]}}</a></li>
                                    @endforeach
                                </ul>
                                @else
                                    
                                @endif
                            </td>
                            <td>
                                @if ($item->SingleImageName!='')
                                    <?php $Single_Image_Name = explode('/',$item->SingleImageName)?>
                                    <a href="{{url($item->SingleImageName)}}" target="_blank">{{$Single_Image_Name[3]}}</a>
                                @else
                                    N/A
                                @endif
                            </td>
                            </tr>   
                            <?php $count++?> 
                            @endforeach
                        @endif
                      
                      
                    </tbody>
                  </table>
            </div>
            </div>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>    
        <script>
            function Changeactive(data)
            {
                console.log(data)
                if(data==1){
                    $('#companyStatus').removeAttr('value').attr('value',1)
                    $('#StatusOn').removeAttr('value').attr('value',0)
                }else if(data==0){
                    $('#companyStatus').removeAttr('value').attr('value',0)  
                    $('#StatusOn').removeAttr('value').attr('value',1)
                }
                
            }
        </script>
    </body>
</html>
