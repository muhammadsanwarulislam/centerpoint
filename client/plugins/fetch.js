export default defineNuxtPlugin((NuxtApp) => {
    const fetcher = async (url, options) => {
      // Retrieve the token from local storage if available
      const token = process.client ? window.localStorage.getItem('token') : null;
      
      // Add the token to the headers if it exists
      if (token) {
        options.headers = {
          ...options.headers,
          Authorization: `Bearer ${token}`,
        };
      }
  
      // Use $fetch to make the request
      return await NuxtApp.$fetch(url, options);
    };
  
    return {
      provide: {
        // Provide the fetcher function as $fetch
        $fetch: fetcher,
      },
    };
  });
  