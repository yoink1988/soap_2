var pageHandler = function(){
    var self = this
    this.xhr = new XMLHttpRequest()
    this.errMsg = ''
    this.msg = ''
    this.formDiv = document.querySelector('.order-form')
    this.formSpan = document.querySelector('#errMsg') 
    this.searchMsg = document.querySelector('#searchMsg')

    this.drawPage = function(){

        var divContent = document.querySelector('.content')
        divContent.innerHTML = ""
        var message = document.querySelector('.msg')
        message.innerHTML = self.msg
        self.msg = ''
        if(!!self.carList)
        {
            var list = JSON.parse(self.carList)
            var divList = document.createElement('ol')
            list.forEach(function(element) {
                var li = document.createElement('li')
                var butt = document.createElement('button')
                butt.setAttribute('onclick', 'ph.getDetails('+element.id+')')
                butt.innerHTML = 'More details>>'
                li.innerHTML = 'Id: '+element.id+', Brand: '+element.brand+', Model: '+element.model
                li.appendChild(butt)
                divList.appendChild(li)
            });
            divContent.appendChild(divList)
            delete self.carList
        }
        if(self.details)
        {
            var list = JSON.parse(self.details)
            var divList = document.createElement('ol')
            divList.setAttribute('class', 'det-list')
            var model = document.createElement('li')
            model.innerHTML = 'Model: '+list.model
            var year = document.createElement('li')
            year.innerHTML = 'Year created: '+list.year
            var motor = document.createElement('li')
            motor.innerHTML = 'Capacity: '+list.motor
            var color = document.createElement('li')
            color.innerHTML = 'Color: '+list.color
            var speed = document.createElement('li')
            speed.innerHTML = 'Max speed: '+list.speed+' km/h'
            var price = document.createElement('li')
            price.innerHTML = 'Price: '+list.price+' $'
            divList.appendChild(model)
            divList.appendChild(year)
            divList.appendChild(motor)
            divList.appendChild(color)
            divList.appendChild(speed)
            divList.appendChild(price)
            divContent.appendChild(divList)
            self.carId = list.id
            self.showOrderForm()
            delete self.details
        }
        if(self.findedCars)
        {

            var cars = JSON.parse(self.findedCars)
            cars.forEach(function(el){
                var carOl = document.createElement('ol')
                carOl.style.marginTop = '20px'
                var brand = document.createElement('li')
                brand.innerHTML = 'Brand: '+el.brand
                var model = document.createElement('li')
                model.innerHTML = 'Model: '+el.model
                var year = document.createElement('li')
                year.innerHTML = 'Year created: '+el.year
                var motor = document.createElement('li')
                motor.innerHTML = 'Capacity: '+el.motor
                var speed = document.createElement('li')
                speed.innerHTML = 'Max speed: '+el.speed+' km/h'
                var color = document.createElement('li')
                color.innerHTML = 'Color: '+el.color
                var price = document.createElement('li')
                price.innerHTML = 'Price: '+el.price+' $'
                var butt = document.createElement('button')
                butt.innerHTML="Details and order"
                butt.setAttribute('onclick', 'ph.getDetails('+el.id+')')
                carOl.appendChild(brand)
                carOl.appendChild(model)
                carOl.appendChild(year)
                carOl.appendChild(motor)
                carOl.appendChild(speed)
                carOl.appendChild(color)
                carOl.appendChild(price)
                carOl.appendChild(butt)
                divContent.appendChild(carOl)
                delete self.findedCars
            })
        }
    }

    this.searchByParameters = function(){
        var searchParams = {}
        searchParams.model = document.querySelector('#model').value
        searchParams.year = document.querySelector('#year').value
        searchParams.motor = document.querySelector('#motor').value
        searchParams.color = document.querySelector('#color').value
        searchParams.speed = document.querySelector('#speed').value
        searchParams.price = document.querySelector('#price').value
        if(searchParams.year.trim() != ''){
            self.xhr.open('POST', 'http://localhost/public_html/MYPHP/soap2/client/carShopClient.php', true)
            var body = 'searchParams='+JSON.stringify(searchParams)
            self.xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            self.xhr.onreadystatechange = function() { 
                if (self.xhr.readyState != 4) return

                if (self.xhr.status != 200) {
                alert(self.xhr.status + ': ' + self.xhr.statusText);
                } else {
                    self.findedCars = self.xhr.responseText
                    self.drawPage()
                    self.formDiv.style.display = 'none'
                }
            
            }
              self.xhr.send(body);
        }
        else{
            self.searchMsg.innerHTML = 'Year field is required to search'
        }
    }

    this.showOrderForm = function(){
        self.formSpan.innerHTML = self.errMsg
        self.formDiv.style.display = 'block'
    }

    this.addOrder = function(){
        var formData = {}
        formData.name = document.getElementById('name').value
        formData.lname = document.getElementById('lname').value
        formData.payment = document.getElementById('payment').value

        if(self.checkOrderForm(formData))
        {
            self.formMsg = ''
            self.xhr.open('POST', 'http://localhost/public_html/MYPHP/soap2/client/carShopClient.php', true)
            var body = 'order='+JSON.stringify({"order":{"idCar":self.carId, "uname":formData.name, "ulname":formData.lname, "payment":formData.payment}})
            self.xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            self.xhr.onreadystatechange = function() { 
                if (self.xhr.readyState != 4) return
    
                  if (self.xhr.status != 200) {
                  alert(self.xhr.status + ': ' + self.xhr.statusText);
                } else {
                    self.msg = self.xhr.responseText
                    self.drawPage()
                    self.formDiv.style.display = 'none'
                }
              
            }
            self.xhr.send(body);
        }
        else
        {
            self.showOrderForm()
        }
    }


    this.checkOrderForm = function(formData){
        if(formData.name.trim() == ''){
            self.errMsg = 'Check Name field'
            return false
        }
        else if(formData.lname.trim() == ''){
            self.errMsg = 'Check LastName field'
            return false
        }
        else if((formData.payment != 'cash') && (formData.payment != 'creditCard')){
            self.errMsg = 'Payment should be "cash" or "creditCard" '
            return false
        }
        return true
    }

    this.getDetails = function(id){
        self.xhr.open('POST', 'http://localhost/public_html/MYPHP/soap2/client/carShopClient.php', true)
        var body = 'getDetails='+id
        self.xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
        self.xhr.onreadystatechange = function() { 
            if (self.xhr.readyState != 4) return

              if (self.xhr.status != 200) {
              alert(self.xhr.status + ': ' + self.xhr.statusText);
            } else {
              self.details = self.xhr.responseText;
              self.drawPage()
            }
        }
        self.xhr.send(body);
    }

    this.getAllCars = function(){
        self.xhr.open('POST', 'http://localhost/public_html/MYPHP/soap2/client/carShopClient.php', true)
        var body = 'getAllCars=1'
        self.xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
        self.xhr.onreadystatechange = function() { 
            if (self.xhr.readyState != 4) return

              if (self.xhr.status != 200) {
              alert(self.xhr.status + ': ' + self.xhr.statusText);
            } else {
              self.carList = self.xhr.responseText;
              self.drawPage()
              self.formDiv.style.display = 'none'
            }
        }
        self.xhr.send(body);
    }
}

var ph = new pageHandler
ph.drawPage()




