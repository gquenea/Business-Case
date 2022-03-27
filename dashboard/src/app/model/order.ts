export class Order {
  public date: string;
  public number: number;
  public averagePrice: number;
  public conversionPercentage: number;
  public cartConversionPercentage: number;
  public droppedCartPercentage: number;
  public recurrence: number;

  constructor(jsonObject?: any) {
    if (jsonObject !== undefined && jsonObject !== null) {
      Object.assign(this, jsonObject);
    }
  }
}
