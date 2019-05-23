import { Pipe, PipeTransform } from '@angular/core';

@Pipe({
  name: 'filter'
})
export class FilterPipe implements PipeTransform {

  transform(data: any, term: any): any {
    // als data undefined is
    if (term ===undefined) return data;
    // zoekopties 
    return data.filter(function(inputdata){
      return inputdata.date.toLowercase().includes(term.toLowercase)
    })
  }

}
