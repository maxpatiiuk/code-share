System.Exception {
	string message;
	IDictionary Data; //pointer to additiona data
	string source;
	string stackTrace;//name and signatures of method, than caused exception
	MethodBase targetSite;//store method, than caused exception
	string helpLink;//url of document
	Exception innerException /*if this ex was generated while working with prev, will save prev here*/
}

//Types of exceptions: SystemException, ApplicationException

try {
	trhow new Exception("Text");
}
catch(Exception e){//catch all exceptions

}
catch {//catch all exceptions but dont transfer their data

}
finally {

}

try {
	trhow new ArgumentOutOfRangeException("Text");
}
catch(FormatException e){

}
catch(DivideByZeroException e){

}
catch(IndexOutOfRangeException e){

}
catch (Exception e){
	Console.WriteLine("Exception: {0}", e.Message);
}
finally {

}

Console.Write("{0}",Enviroment.NewLine);// \n

strign s;
if(s == string.Empty);

namespace RethrowException;//to allow exceptions be thrown in catch{}

try {
	unchecked {
		//code in here canNot throw OverflowException
	}
}