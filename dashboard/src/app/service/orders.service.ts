import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Order } from '../model/order';
import { map, Observable } from 'rxjs';
import { ApiUtils } from './apiUtils';

@Injectable()
export class OrdersService {

  constructor(private http: HttpClient) {
  }

  getOrders(startDate: string, endDate: string): Observable<Order[]> {
    return this.http
      .get(
        ApiUtils.API_URL + '/orders',
        {
          params: {
            'startDate': startDate,
            'endDate': endDate
          }
        }
      )
      .pipe(
        map(data => data as Order[])
      );
  }
}
